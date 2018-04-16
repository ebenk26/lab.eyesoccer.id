<div style='display: none;'><html><body></body></html></div>

<script>
    $(function() {
        $('.chosen-select').chosen();
        $('.chosen-select-deselect').chosen({ allow_single_deselect: true });
        $('.chosen-container').css({width: '100%'});
    });
</script>
<div class='boxtitle'><?php echo $title; ?></div>
<div id='boxmessage'></div>

<div id='boxjq'>
    <div id='boxbutton'>
        <a href="javascript:void(0)" id='button' onclick="actmenu('member/view')">Back</a>
        
        <div style='clear: both;'></div>
    </div>
    <?php echo form_open_multipart('member/update', array('name' => 'form_addmulti', 'id' => 'form_addmulti')); ?>
    <div id='boxtable' class='shadow'>
        <div class='row'>
            <div class='col-lg-8 col-md-12 col-sm-8 col-xs-12'>
                <div class='boxtab pad-all mg-b20'>
                    <h1>Edit</h1>
                    <div class='pad-lr20'>
                        <input type='hidden' name='idx' id='idx' value='<?php echo $dt1->id_member; ?>'>
                        <input type='hidden' name='val' value='true'>
                        <div class='mg-b10'>
                            <label>Username</label>
                            <input type='text' name='username' id='username' value='<?php echo $dt1->username ?>' class='cinput input_multi' required>
                        </div>
                        <div class='mg-b10'>
                            <label>Name</label>
                            <input type='text' name='name' id='name' value='<?php echo $dt1->name ?>' class='cinput input_multi' required>
                        </div>
                          <div class='mg-b10'>
                            <label>phone</label>
                            <input type='text' name='name' id='name' value='<?php echo $dt1->phone ?>' class='cinput input_multi' required>
                        </div>
                       
                       <div class='mg-b10'>
                            <label>Email </label>
                            <input type="text" name="email" class="cinput input_multi" value="<?php echo $dt1->email?>">
                        </div>  
                        <div class='mg-b10'>
                            <label>City</label>

                            <input type="text" name="city" class="cinput input_multi" value="<?php echo $dt1->city?>">

                        </div>
                        <div class='mg-b10'>
                            <label>Zip </label>
                            <input type="text" name="zip" class="cinput input_multi" value="<?php echo $dt1->zip?>" >
                        </div>
                        <div class='mg-b10'>
                            <label>Address</label>
                            <textarea name="address" id="address" class="tiny-active">
                                <?php echo $dt1->address?>
                                
                            </textarea>   

                        </div>
                        <div class='pad-b20'>
                            <label>about</label>
                            <textarea name="address" id="about" class="tiny-active">
                                <?php echo $dt1->about?>
                            </textarea>
                            

                        </div>
                    </div>
                </div>
            </div>
            
            <div class='col-lg-4 col-md-12 col-sm-4 col-xs-12'>
                <div class='boxtab pad-all mg-b20'>
                    <h1>Gender</h1>
                    <div class='pad-lr20'>
                        <div class='pad-b20'>
                            <label>Active</label>
                            <select name="active" id="active" class="cinput select_multi tx-cp">
                                <?php
                                 
                                    for ($i = 1; $i >=  0;$i--){
                                        echo '<option '.($i === $dt1->gender ? 'selected' : '').' value="'.($i == '1' ? 'Laki-Laki' : 'Perempuan').'">'.($i == '1' ? 'MALE' : 'FEMALE').'</option>';

                                    } 
                            
                                ?>
                            </select>
                        </div>
                        
                    </div>
                </div>
                <div class='boxtab pad-all mg-b20'>
                    <h1>Status</h1>
                    <div class='pad-lr20'>
                        <div class='pad-b20'>
                            <label>Active</label>
                            <select name="active" id="active" class="cinput select_multi tx-cp">
                                <?php
                                 
                                    for ($i = 1; $i >=  0;$i--){
                                        echo '<option '.($i == $dt1->active ? 'selected' : '').' value="'.$i.'">'.($i == '0' ? 'NO' : 'YES').'</option>';

                                    }         
                                ?>
                            </select>
                        </div>
                       
                    </div>
                </div>
                <input type='submit' value='update' id='btn_submit' onclick="saveaddmulti('member/update')">
            
            </div>
            
            <div class='clean'></div>
        </div>
    </div>
</div>