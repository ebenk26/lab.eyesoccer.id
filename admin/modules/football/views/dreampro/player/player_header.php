<?php
    $sv = $this->library->sub_view();
    if(isset($_GET['id']))
    {
        $query = array('id_player' => $_GET['id'], 'count' => true);

        $cccareer = $this->excurl->reqCurl('player-career', $query);
        $cccareer = ($cccareer) ? $cccareer->data[0]->cc : 0;

        $ccachive = $this->excurl->reqCurl('player-achievement', $query);
        $ccachive = ($ccachive) ? $ccachive->data[0]->cc : 0;

        $ccgallery = $this->excurl->reqCurl('list-pic', $query);
        $ccgallery = ($ccgallery) ? $ccgallery->data[0]->cc : 0;

        ?>
        <div id='boxbutton'>
            <a href="javascript:void(0)" id='button' onclick="actmenu('football/player/view<?php echo $sv->idback; ?>')">Back</a>

            <div class='search' style='margin-top: 0;'>
                <a href="javascript:void(0)" id='button' class='<?php echo ($tab == 'career') ? 'btn-active' : ''; ?>' onclick="actmenu('football/playercareer/view<?php echo $sv->idstay; ?>')">Career (<?= $cccareer ?>)</a>
                <a href="javascript:void(0)" id='button' class='<?php echo ($tab == 'achievement') ? 'btn-active' : ''; ?>' onclick="actmenu('football/playerachieve/view<?php echo $sv->idstay; ?>')">Achievement (<?= $ccachive ?>)</a>
                <a href="javascript:void(0)" id='button' class='<?php echo ($tab == 'gallery') ? 'btn-active' : ''; ?>' onclick="actmenu('football/playergallery/view<?php echo $sv->idstay; ?>')">Gallery (<?= $ccgallery ?>)</a>
            </div>
            <div style='clear: both;'></div>
        </div>
        <?php
    }
?>