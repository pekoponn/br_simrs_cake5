<?php $dataChild = $this->Html->link('Tanggal Libur', ['action' => 'index'], ['full_base' => true]); ?>
<?= $this->Krs->breadcrumb('HRGA', $dataChild, 'Buat') ?>

<div class="panel panel-inverse">
    <div class="panel-body">
        <?php echo $this->Form->control('is_create', ['type' => 'hidden', 'value' => $getUser->id, 'id' => 'user']); ?>
        <div id="calendar"></div>
    </div>
</div>


<div id="modal" class="modal modal-top fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Hari Libur</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-2">
                        Tanggal
                    </div>
                    <div class="col-md-10">
                        <?php 
                        echo $this->Form->control('date', ['label'=>false,'type' => 'text', 'class'=>'form-control-plaintext tgl', 'readonly'=>true]); 
                        // echo $this->Form->control('date', ['type' => 'hidden', 'class'=>'tgl', 'Y-m-d'), 'id' => 'user']);
                     
                        ?> 

                        
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-2">
                        Keterangan
                    </div>
                    <div class="col-md-10">
                        <?= $this->Form->control('description', ['label' => false, 'class' => 'form-control desc', 'type' => 'textarea']); ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button onclick="save()" class="btn btn-primary" data-dismiss="modal">Simpan</button>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(() => {

    });
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var modal = document.getElementById('modal');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
            },
            initialDate: moment().format('YYYY-MM-DD'),
            navLinks: true, // can click day/week names to navigate views
            // businessHours: true, // display business hours
            businessHours: {
                daysOfWeek: [1, 2, 3, 4, 5, 6],
            },
            editable: true,
            selectable: true,
            events:<?= $data ?>,
            dateClick: function(val) {
                $('#modal').modal('show');
                $('.tgl').val(val.dateStr);
            }
        });
        calendar.render();
    });

    function save() {
        $.ajax({
            method: 'POST',
            url: '<?php echo $this->Url->build(['prefix' => 'Hr', 'controller' => 'HrgaHolidays', 'action' => 'add', '_full' => true]) ?>',
            dataType: 'json',
            data: {
                date: $('.tgl').val(),
                desc: $('.desc').val(),
                user: $('#user').val()
            },
            headers: {
                'X-CSRF-Token': $('meta[name="csrfToken"]').attr('content')
            },
            success: function(data) {
                if (data.status == 'success') {
                    window.location.reload()
                    //window.location.href = '/hga/hrga-holidays'
                } else {
                    alert('error mengirim data')
                }
            },
            error: function(err) {
                alert('error ambil data');
            }
        });
    }
</script>