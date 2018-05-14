<?php
    $sv = $this->library->sub_view();
    if(isset($_GET['id']))
    {
        $query = array('id_club' => $_GET['id'], 'count' => true);

        $ccplayer = $this->excurl->reqCurl('profile', $query);
        $ccplayer = ($ccplayer) ? $ccplayer->data[0]->cc : 0;

        $ccofficial = $this->excurl->reqCurl('profile-official', $query);
        $ccofficial = ($ccofficial) ? $ccofficial->data[0]->cc : 0;

        $cccareer = $this->excurl->reqCurl('club-career', $query);
        $cccareer = ($cccareer) ? $cccareer->data[0]->cc : 0;

        $ccgallery = $this->excurl->reqCurl('list-pic', $query);
        $ccgallery = ($ccgallery) ? $ccgallery->data[0]->cc : 0;

        ?>
        <div id='boxbutton'>
            <a href="javascript:void(0)" id='button' onclick="actmenu('football/club/view<?php echo $sv->idback; ?>')">Back</a>

            <div class='search' style='margin-top: 0;'>
                <a href="javascript:void(0)" id='button' class='<?php echo ($tab == 'player') ? 'btn-active' : ''; ?>' onclick="actmenu('football/player/view<?php echo $sv->idstay; ?>')">Player (<?= $ccplayer; ?>)</a>
                <a href="javascript:void(0)" id='button' class='<?php echo ($tab == 'official') ? 'btn-active' : ''; ?>' onclick="actmenu('football/official/view<?php echo $sv->idstay; ?>')">Official (<?= $ccofficial; ?>)</a>
                <a href="javascript:void(0)" id='button' class='<?php echo ($tab == 'achievement') ? 'btn-active' : ''; ?>' onclick="actmenu('football/clubcareer/view<?php echo $sv->idstay; ?>')">Achievement (<?= $cccareer; ?>)</a>
                <a href="javascript:void(0)" id='button' class='<?php echo ($tab == 'gallery') ? 'btn-active' : ''; ?>' onclick="actmenu('football/clubgallery/view<?php echo $sv->idstay; ?>')">Gallery (<?= $ccgallery; ?>)</a>
            </div>
            <div style='clear: both;'></div>
        </div>
        <?php
    }
?>