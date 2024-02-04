<?php
require '../db_connect.php';
if(isset($_GET['id'])){
  $qry = $conn->query("SELECT * from tb_data where id = ".$_GET['id']);
  foreach($qry->fetch_array() as $k => $val){
    $$k = $val;
  }
}
?>
<form id="manage-report">
    <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
    <div class="form-group">
        <label for="languages">Languages</label>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="Civil and Sanitary" name="languages[]" id="civil_and_sanitary" <?php echo isset($languages) && in_array('Civil and Sanitary',explode(",",$languages)) ? 'checked' : '' ?>>
            <label class="form-check-label" for="civil_and_sanitary">
                Civil and Sanitary
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="Electrical" name="languages[]" id="electrical">
            <label class="form-check-label" for="electrical" <?php echo isset($languages) && in_array('Electrical',explode(",",$languages)) ? 'checked' : '' ?>>
                Electrical
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="Mechanical" name="languages[]" id="mechanical">
            <label class="form-check-label" for="mechanical" <?php echo isset($languages) && in_array('Mechanical',explode(",",$languages)) ? 'checked' : '' ?>>
                Mechanical
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="Electronic and Communication" name="languages[]" id="electronic_and_communication" <?php echo isset($languages) && in_array('Electronic and Communication',explode(",",$languages)) ? 'checked' : '' ?>>
            <label class="form-check-label" for="electronic_and_communication">
                Electronic and Communication
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="ICT" name="languages[]" id="ict" <?php echo isset($languages) && in_array('ICT',explode(",",$languages)) ? 'checked' : '' ?>>
            <label class="form-check-label" for="ict">
                ICT
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="Others" name="languages[]" id="others" <?php echo isset($languages) && in_array('Others',explode(",",$languages)) ? 'checked' : '' ?>>
            <label class="form-check-label" for="others">
                Others
            </label>
        </div>
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" rows="3" name="description"><?php echo isset($description) ? $description : '' ?></textarea>
    </div>
</form>
<script>
    $(document).ready(function(){
        $('#manage-report').submit(function(e){
            e.preventDefault();
            start_load()
            $.ajax({
                url:'ajax.php?action=save_report',
                method:'POST',
                data:$(this).serialize(),
                success:function(resp){
                    if(resp == 1){
                        alert_toast("Data successfully saved.","success");
                        setTimeout(function(){
                            location.reload()	
                        },1750)
                    }
                }
            })
        })
    })
</script>