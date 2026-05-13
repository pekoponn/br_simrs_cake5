<?php
/**
 * @var \App\View\AppView $this
 * @var array $params
 * @var string $message
 */
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<?php 
/*<div class="message error" onclick="this.classList.add('hidden');"><?= $message ?></div>*/
// Tambahan untuk mengubah pesan 
?>
<div class="alert alert-danger alert-dismissible fade show">
    <strong>Gagal :</strong> <?= $message ?>
</div>