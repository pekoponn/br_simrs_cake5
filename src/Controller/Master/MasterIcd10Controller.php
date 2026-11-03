<?php
declare(strict_types=1);

namespace App\Controller\Master;

use App\Controller\AppController;

class MasterIcd10Controller extends AppController
{
    public function index()
    {
        $q = $this->request->getQuery('q', '');
        $isActive = $this->request->getQuery('is_active', '');

        $conditions = [];

        if (!empty($q)) {
            $conditions['OR'] = [
                'MasterIcd10.kode LIKE' => '%' . $q . '%',
                'MasterIcd10.nama LIKE' => '%' . $q . '%',
            ];
        }

        if ($isActive !== '') {
            $conditions['MasterIcd10.is_active'] = (int)$isActive;
        }

        $query = $this->MasterIcd10->find()
            ->where($conditions);

        $this->paginate = [
            'order' => ['MasterIcd10.kode' => 'ASC'],
            'limit' => 50,
        ];

        $masterIcd10 = $this->paginate($query);

        $this->set(compact('masterIcd10', 'q', 'isActive'));
    }

    public function view($id = null)
    {
        $masterIcd10 = $this->MasterIcd10->get($id);

        $this->set(compact('masterIcd10'));
    }

    public function add()
    {
        $masterIcd10 = $this->MasterIcd10->newEmptyEntity();

        if ($this->request->is('post')) {
            $data = $this->_normalizeData($this->request->getData());
            $masterIcd10 = $this->MasterIcd10->patchEntity($masterIcd10, $data);

            if ($this->MasterIcd10->save($masterIcd10)) {
                $this->Flash->success(__('Data ICD-10 berhasil disimpan.'));

                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('Gagal menyimpan. Silakan coba lagi.'));
        }

        $this->set(compact('masterIcd10'));
    }

    public function import()
    {
        $result = null;

        if ($this->request->is(['post', 'put'])) {
            $file = $this->request->getData('file');
            $result = $this->_importUploadedFile($file);

            if (!empty($result['success'])) {
                $this->Flash->success(__(
                    'Import selesai. Baru: {0}, Update: {1}, Lewati: {2}, Gagal: {3}.',
                    $result['inserted'],
                    $result['updated'],
                    $result['skipped'],
                    $result['failed']
                ));
            } else {
                $this->Flash->error($result['message'] ?? 'Import gagal. Periksa file lalu coba lagi.');
            }
        }

        $this->set(compact('result'));
    }

    public function edit($id = null)
    {
        $masterIcd10 = $this->MasterIcd10->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->_normalizeData($this->request->getData());
            $masterIcd10 = $this->MasterIcd10->patchEntity($masterIcd10, $data);

            if ($this->MasterIcd10->save($masterIcd10)) {
                $this->Flash->success(__('Data ICD-10 berhasil diubah.'));

                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('Gagal mengubah. Silakan coba lagi.'));
        }

        $this->set(compact('masterIcd10'));
    }

    public function toggleActive($id = null)
    {
        $this->request->allowMethod(['post']);
        $this->autoRender = false;

        try {
            $row = $this->MasterIcd10->get($id);
            $row->is_active = $row->is_active ? 0 : 1;
            $saved = $this->MasterIcd10->save($row);

            return $this->_json([
                'success' => (bool)$saved,
                'is_active' => $row->is_active,
                'message' => $saved
                    ? ($row->is_active ? 'Diaktifkan' : 'Dinonaktifkan')
                    : 'Gagal mengubah status',
            ]);
        } catch (\Exception $e) {
            return $this->_json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $row = $this->MasterIcd10->get($id);

        if ($this->MasterIcd10->delete($row)) {
            $this->Flash->success(__('Data ICD-10 berhasil dihapus.'));
        } else {
            $this->Flash->error(__('Gagal menghapus data ICD-10.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function search()
    {
        $this->request->allowMethod(['get']);
        $this->autoRender = false;

        $q     = trim((string)$this->request->getQuery('q'));
        $limit = min((int)$this->request->getQuery('limit', $q === '' ? 500 : 50), 500);

        $query = $this->MasterIcd10->find()
            ->select(['kode', 'nama'])
            ->where(['MasterIcd10.is_active' => 1]);

        if ($q !== '') {
            $query->where([
                'OR' => [
                    'MasterIcd10.kode LIKE' => '%' . $q . '%',
                    'MasterIcd10.nama LIKE' => '%' . $q . '%',
                ],
            ]);
        }

        $results = $query
            ->order(['MasterIcd10.kode' => 'ASC'])
            ->limit($limit)
            ->enableHydration(false)
            ->toArray();

        $data = array_map(function ($row) {
            return [
                'kode' => $row['kode'],
                'nama' => $row['nama'],
            ];
        }, $results);

        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode($data));
    }

    private function _normalizeData(array $data): array
    {
        if (!isset($data['is_active'])) {
            $data['is_active'] = 1;
        }
        $data['is_active'] = (int)$data['is_active'];

        foreach (['kode', 'nama'] as $field) {
            if (isset($data[$field])) {
                $data[$field] = trim((string)$data[$field]);
                if ($data[$field] === '') {
                    $data[$field] = null;
                }
            }
        }

        return $data;
    }

    private function _importUploadedFile($file): array
    {
        if (empty($file) || !method_exists($file, 'getError')) {
            return ['success' => false, 'message' => 'File belum dipilih.'];
        }

        if ($file->getError() !== UPLOAD_ERR_OK) {
            return ['success' => false, 'message' => 'Upload file gagal.'];
        }

        $filename = (string)$file->getClientFilename();
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $allowed = ['csv', 'txt', 'xlsx'];

        if (!in_array($extension, $allowed, true)) {
            return ['success' => false, 'message' => 'Format file harus CSV atau XLSX.'];
        }

        $tmpPath = $file->getStream()->getMetadata('uri');
        if (empty($tmpPath) || !is_readable($tmpPath)) {
            return ['success' => false, 'message' => 'File tidak bisa dibaca.'];
        }

        try {
            $rows = $extension === 'xlsx'
                ? $this->_readXlsxRows($tmpPath)
                : $this->_readCsvRows($tmpPath);
        } catch (\Throwable $e) {
            return ['success' => false, 'message' => 'Gagal membaca file: ' . $e->getMessage()];
        }

        if (empty($rows)) {
            return ['success' => false, 'message' => 'Tidak ada data valid. Pastikan kolom CODE dan DISPLAY tersedia.'];
        }

        $summary = [
            'success' => true,
            'inserted' => 0,
            'updated' => 0,
            'skipped' => 0,
            'failed' => 0,
            'duplicates' => 0,
            'errors' => [],
        ];

        $prepared = [];
        foreach ($rows as $rowNumber => $row) {
            $kode = trim((string)($row['kode'] ?? ''));
            $nama = trim((string)($row['nama'] ?? ''));

            if ($kode === '' || $nama === '') {
                $summary['skipped']++;
                continue;
            }

            if (isset($prepared[$kode])) {
                $summary['duplicates']++;
            }

            $prepared[$kode] = [
                'row' => $rowNumber,
                'kode' => $kode,
                'nama' => $nama,
                'is_active' => 1,
            ];
        }

        if (empty($prepared)) {
            $summary['success'] = false;
            $summary['message'] = 'Tidak ada data yang bisa diimport.';
            return $summary;
        }

        $existingRows = $this->MasterIcd10->find()
            ->select(['id', 'kode'])
            ->where(['kode IN' => array_keys($prepared)])
            ->enableHydration(false)
            ->toArray();

        $existingMap = [];
        foreach ($existingRows as $row) {
            $existingMap[$row['kode']] = (int)$row['id'];
        }

        $connection = $this->MasterIcd10->getConnection();

        $connection->transactional(function () use (&$summary, $prepared, $existingMap) {
            foreach ($prepared as $data) {
                if (isset($existingMap[$data['kode']])) {
                    $entity = $this->MasterIcd10->get($existingMap[$data['kode']]);
                    $entity = $this->MasterIcd10->patchEntity($entity, $data);
                    $isUpdate = true;
                } else {
                    $entity = $this->MasterIcd10->newEntity($data);
                    $isUpdate = false;
                }

                if ($this->MasterIcd10->save($entity)) {
                    if ($isUpdate) {
                        $summary['updated']++;
                    } else {
                        $summary['inserted']++;
                    }
                    continue;
                }

                $summary['failed']++;
                if (count($summary['errors']) < 20) {
                    $summary['errors'][] = 'Baris ' . $data['row'] . ' (' . $data['kode'] . ') gagal disimpan.';
                }
            }
        });

        return $summary;
    }

    private function _readCsvRows(string $path): array
    {
        $handle = fopen($path, 'r');
        if (!$handle) {
            throw new \RuntimeException('File CSV tidak bisa dibuka.');
        }

        $firstLine = fgets($handle);
        if ($firstLine === false) {
            fclose($handle);
            return [];
        }

        $delimiter = $this->_detectDelimiter($firstLine);
        rewind($handle);

        $headers = null;
        $rows = [];
        $rowNumber = 0;

        while (($row = fgetcsv($handle, 0, $delimiter)) !== false) {
            $rowNumber++;
            if ($rowNumber === 1) {
                $headers = $this->_normalizeImportHeaders($row);
                continue;
            }

            $mapped = $this->_mapImportRow($headers, $row);
            if ($mapped !== null) {
                $rows[$rowNumber] = $mapped;
            }
        }

        fclose($handle);

        return $rows;
    }

    private function _readXlsxRows(string $path): array
    {
        if (!class_exists('\ZipArchive')) {
            throw new \RuntimeException('Ekstensi PHP ZipArchive belum aktif. Gunakan file CSV.');
        }

        $zip = new \ZipArchive();
        if ($zip->open($path) !== true) {
            throw new \RuntimeException('File XLSX tidak bisa dibuka.');
        }

        $sharedStrings = [];
        $sharedXml = $zip->getFromName('xl/sharedStrings.xml');
        if ($sharedXml !== false) {
            $shared = simplexml_load_string($sharedXml);
            foreach ($shared->si as $si) {
                if (isset($si->t)) {
                    $sharedStrings[] = (string)$si->t;
                    continue;
                }

                $text = '';
                foreach ($si->r as $run) {
                    $text .= (string)$run->t;
                }
                $sharedStrings[] = $text;
            }
        }

        $sheetXml = $zip->getFromName('xl/worksheets/sheet1.xml');
        if ($sheetXml === false) {
            $zip->close();
            throw new \RuntimeException('Worksheet pertama tidak ditemukan.');
        }

        $sheet = simplexml_load_string($sheetXml);
        $rows = [];
        $headers = null;

        foreach ($sheet->sheetData->row as $row) {
            $rowNumber = (int)$row['r'];
            $values = [];

            foreach ($row->c as $cell) {
                $ref = (string)$cell['r'];
                $column = preg_replace('/\d+/', '', $ref);
                $index = $this->_columnNameToIndex($column);
                $type = (string)$cell['t'];
                $value = isset($cell->v) ? (string)$cell->v : '';

                if ($type === 's' && $value !== '') {
                    $value = $sharedStrings[(int)$value] ?? '';
                } elseif ($type === 'inlineStr' && isset($cell->is->t)) {
                    $value = (string)$cell->is->t;
                }

                $values[$index] = $value;
            }

            if ($rowNumber === 1) {
                ksort($values);
                $headers = $this->_normalizeImportHeaders(array_values($values));
                continue;
            }

            ksort($values);
            $mapped = $this->_mapImportRow($headers, array_values($values));
            if ($mapped !== null) {
                $rows[$rowNumber] = $mapped;
            }
        }

        $zip->close();

        return $rows;
    }

    private function _detectDelimiter(string $line): string
    {
        $delimiters = [',' => 0, ';' => 0, "\t" => 0];
        foreach ($delimiters as $delimiter => $count) {
            $delimiters[$delimiter] = count(str_getcsv($line, $delimiter));
        }

        arsort($delimiters);

        return (string)array_key_first($delimiters);
    }

    private function _normalizeImportHeaders(array $headers): array
    {
        $normalized = [];
        foreach ($headers as $index => $header) {
            $key = strtolower(trim((string)$header));
            $key = preg_replace('/^\xEF\xBB\xBF/', '', $key);
            $key = preg_replace('/[^a-z0-9]+/', '_', $key);
            $key = trim($key, '_');
            $normalized[$key] = $index;
        }

        return $normalized;
    }

    private function _mapImportRow(?array $headers, array $row): ?array
    {
        if (empty($headers)) {
            return null;
        }

        $codeIndex = $headers['code'] ?? $headers['kode'] ?? null;
        $displayIndex = $headers['display'] ?? $headers['nama'] ?? $headers['description'] ?? null;

        if ($codeIndex === null || $displayIndex === null) {
            return null;
        }

        return [
            'kode' => $row[$codeIndex] ?? '',
            'nama' => $row[$displayIndex] ?? '',
        ];
    }

    private function _columnNameToIndex(string $column): int
    {
        $column = strtoupper($column);
        $index = 0;
        $length = strlen($column);

        for ($i = 0; $i < $length; $i++) {
            $index = ($index * 26) + (ord($column[$i]) - 64);
        }

        return $index - 1;
    }

    private function _json($data, int $status = 200): \Cake\Http\Response
    {
        return $this->response
            ->withStatus($status)
            ->withType('application/json')
            ->withHeader('Cache-Control', 'no-cache, no-store')
            ->withStringBody(json_encode($data, JSON_UNESCAPED_UNICODE));
    }
}
