<?php
    $sv = $this->library->sub_view();
    if(isset($_GET['id']))
    {
        ?>
        <div id='boxbutton'>
            <a href="javascript:void(0)" id='button' onclick="actmenu('football/club/view<?php echo $sv->idback; ?>')">Back</a>

            <div class='search' style='margin-top: 0;'>
                <a href="javascript:void(0)" id='button' class='<?php echo ($tab == 'player') ? 'btn-active' : ''; ?>' onclick="actmenu('football/player/view<?php echo $sv->idstay; ?>')">Player</a>
                <a href="javascript:void(0)" id='button' class='<?php echo ($tab == 'official') ? 'btn-active' : ''; ?>' onclick="actmenu('football/official/view<?php echo $sv->idstay; ?>')">Official</a>
                <a href="javascript:void(0)" id='button' class='<?php echo ($tab == 'achievement') ? 'btn-active' : ''; ?>' onclick="actmenu('football/clubcareer/view<?php echo $sv->idstay; ?>')">Achievement</a>
                <a href="javascript:void(0)" id='button' class='<?php echo ($tab == 'gallery') ? 'btn-active' : ''; ?>' onclick="actmenu('football/clubgallery/view<?php echo $sv->idstay; ?>')">Gallery</a>
            </div>
            <div style='clear: both;'></div>
        </div>
        <?php
    }
?>