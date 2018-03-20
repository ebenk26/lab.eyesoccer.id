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
   
    <?php echo form_open_multipart('member/save', array('name' => 'form_addmulti', 'id' => 'form_addmulti')); ?>
    <div id='boxtable' class='shadow'>
    
        <div class='row'>
            <div class='col-lg-8 col-md-12 col-sm-8 col-xs-12'>
                <div class='boxtab pad-all mg-b20'>
                    <h1>Add New User</h1>
                    <div class='pad-lr20'>
                        <input type='hidden' name='val' value='true'>
                        <div class='mg-b10'>
                            <label>Username</label>
                            <input type='text' name='username' id='title' class='cinput input_multi' >
                        </div>
                        <div class='mg-b10'>
                            <label>Nama</label>
                            <input type="text" name="name" class="cinput input_multi" >
                        </div>
                        
                        <div class='mg-b10'>
                            <label>Password  <a href="javascript:void(0)" onclick="genpass()"> generate password</a> </label>
                            <input type="password" name="password" class="cinput input_multi"  id="pass">
                
                        </div>
                        <div class='mg-b10'>
                            <label>Confirm Password</label>

                            <input type="password" name="password" class="cinput input_multi"  id="cpass">
                           
                            <span id="respass" style="color:#960000"></span>

                        </div>
                        <div class='mg-b10'>
                            <label>Phone</label>

                            <input type="number" name="phone" class="cinput input_multi" >

                        </div>
                        <div class='mg-b10'>
                            <label>Email </label>
                            <input type="text" name="email" class="cinput input_multi" >
                        </div>  
                        <div class='mg-b10'>
                            <label>City</label>

                            <input type="text" name="city" class="cinput input_multi" >

                        </div>
                        <div class='mg-b10'>
                            <label>Zip </label>
                            <input type="number" name="zip" class="cinput input_multi" >
                        </div>
                        <div class='mg-b10'>
                            <label>Address</label>
                            <textarea name="address" id="address" class="tiny-active">
                                
                            </textarea>   

                        </div>
                        <div class='pad-b20'>
                            <label>About</label>
                            <textarea name="about" id="about" class="tiny-active">
                                
                            </textarea>
                            

                        </div>
                        
                    </div>
                </div>
            </div>
            
            <div class='col-lg-4 col-md-12 col-sm-4 col-xs-12'>
                <div class='boxtab pad-all mg-b20'>
                    <h1>Additional</h1>
                    <div class='pad-lr20'>
                        <div class='pad-b20'>
                            <label>Gender</label>
                            <select name="gender" id="gender" class="cinput select_multi tx-cp">
                                <?php
                                 
                                    for ($i = 1; $i >=  0;$i--){
                                        echo $i;
                                        echo '<option value="'.($i == '1' ? 'Laki-Laki' : 'Perempuan').'">'.($i == '1' ? 'MALE' : 'FEMALE').'</option>';

                                    } 
                            
                                ?>
                            </select>
                        </div>
                    </div>
                   
                </div>
                <div class='boxtab pad-all mg-b20'>
                    <h1>Status</h1>
                    <div class='pad-lr20'>
                        <div class='mg-b10'>
                            <label>Active</label>
                            <select name="active" id="active" class="cinput select_multi tx-cp">
                                <option value="">- Select -</option>
                                <?php
                                 
                                    for ($i = 1; $i >=  0;$i--){
                                        echo '<option value="'.$i.'">'.($i == '0' ? 'NO' : 'YES').'</option>';

                                    } 
                            
                                ?>
                            </select>
                        </div>
                        <div class='pad-b20'>
                            <label>Verification</label>
                            <select name="verification" id="verification" class="cinput select_multi tx-cp">
                                <option value="">- Select -</option>
                                <?php
                                 
                                    for ($i = 1; $i >=  0;$i--){
                                        echo '<option value="'.$i.'">'.($i == '0' ? 'NO' : 'YES').'</option>';

                                    } 
                            
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                
                <input type='submit' value='Save' id='btn_submit' onclick="saveaddmulti('member/save')">
            
            </div>
            
            <div class='clean'></div>
        </div>
    </div>
</div>
<script>

    function generate(len = 10 ){
        var pattern = 'abcdefghijklmnopqrstuvwxyxABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        var gen = '';
        for(let i = 0 ; i < len ; i ++ ){
            let n = pattern.length;
            gen += pattern.charAt(Math.floor(Math.random() * n));
        }
        return gen;
        //console.log(arr.random());
    }
    function genpass(){
        let str = generate(8);
        $('#pass').val(str);
        $('#cpass').val(str);
        $('#respass').html('Your Password : ' + str);
    }
</script>