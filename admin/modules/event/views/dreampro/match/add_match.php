

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
        <a href="javascript:void(0)" id='button' onclick="actmenu('match/view')">Back</a>
        
        <div style='clear: both;'></div>
    </div>
    
    <?php echo form_open_multipart('event/match/save', array('name' => 'form_addmulti', 'id' => 'form_addmulti')); ?>
    <div id='boxtable' class='shadow'>
        <div class='row'>
            <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                <div class='boxtab pad-all mg-b20'>
                    <h1>Event</h1>
                    <div class='pad-lr20'>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class='mg-b10'>
                                    <label>Event / Liga</label>
                                    <div class='mg-b10 pos-rel wd-100'>
                                        <input type="text" class="input_multi" id="event_99" name="event" autocomplete="off"
                                               onkeyup="autocommulti('event/match/autoevent/event/99')" placeholder="Search event in here...">
                                        <div id="boxresult" class="showhide_99" style="display: none;"><div class="result_99"></div></div>
                                        <div class="showevent"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <div class='mg-b10'>
                                    <label>Jadwal Pertandingan</label>
                                    <div class='layout-row'>
                                        <input type='text' name='jadwal_pertandingan' id='jadwal_pertandingan' value='<?php echo date('d-m-Y H:i'); ?>' class='cinput input_multi date_time mg-r10' required>
                                        <span class='flex'></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <div class='mg-b10'>
                                    <label>Stadion</label>
                                    <input type="text" name="lokasi_pertandingan" id="lokasi_pertandingan" class="input_multi">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <div class='pad-b20'>
                                    <label>Live TV</label>
                                    <input type="text" name="live_pertandingan" id="live_pertandingan" class="input_multi">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12'>
                <div class='boxtab pad-all mg-b20'>
                    <h1>Team A</h1>
                    <div class='pad-lr20'>
                        <input type='hidden' name='val' value='true'>
                        <div class='mg-b10 pos-rel wd-100'>    
                            <label>Pilih Team A</label>
                            <input type="text" class="input_multi" id="team_a_0" name="team_a" value="" autocomplete="off" onkeyup="autocommulti('event/match/autoteam/team_a/0')" placeholder="Search team in here..." required="">
                            <input type="hidden" name="team_a_id" id="team_a_id_0">
                            <div id="boxresult" class="showhide_0" style="display: none;"><div class="result_0"></div></div>
                        </div>
                        <div class='pad-b20'>
                            <label>Score Team A</label>
                            <input type="number" name="score_a" id="score_a" class="input_multi" min="0">
                        </div>
                    </div>
                </div>
            </div>

            <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12'>
                <div class='boxtab pad-all mg-b20'>
                    <h1>Team B</h1>
                    <div class='pad-lr20'>
                        <input type='hidden' name='val' value='true'>
                        <div class='mg-b10 pos-rel wd-100'>
                            <label>Pilih Team B</label>
                            <input type="text" class="input_multi" id="team_b_1" name="team_b" value="" autocomplete="off" onkeyup="autocommulti('event/match/autoteam/team_b/1')" placeholder="Search team in here..." required="">
                            <input type="hidden" name="team_b_id" id="team_b_id_1">
                            <div id="boxresult" class="showhide_1" style="display: none;"><div class="result_1"></div></div>
                        </div>
                        <div class='pad-b20'>
                            <label>Score Team B</label>
                            <input type="number" name="score_b" id="score_b" class="input_multi" min="0">
                        </div>
                    </div>
                </div>
            </div>
            
            <div class='clean'></div>
        </div>
    </div>
    <div id='boxsubmit'>
        <input type='submit' value='Save' id='btn_submit' onclick="saveaddmulti('event/match/save')">
        
        <div style='clear: both;'></div>
    </div>
</div>