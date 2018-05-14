<table id='routertable'>
    <tr>
        <?php $sv = $this->library->sub_view(); ?>
        <div id='showsort' value='football/competition/search<?php echo $sv->idstay; ?>'></div>
        <th style='width: 5%;'>
            <input type='checkbox' name='checkall' id='checkall' onclick='actcheckall(this.id);'>
        </th>
        <th style='width: 15%;'>
            <a href="javascript:void(0)" class='csort' id="id_player" val="desc" onclick="actsort(this.id)">Images</a>
        </th>
        <th>
            <a href="javascript:void(0)" class='csort' id="name" val="desc" onclick="actsort(this.id)">Player Detail</a>
        </th>
        <th class='hd-mobile' style='width: 20%;'>
            <a href="javascript:void(0)" class='csort' id="club" val="desc" onclick="actsort(this.id)">Club</a>
        </th>
        <th class='hd-mobile' style='width: 10%;'>
            <a href="javascript:void(0)" class='csort' id="is_active" val="desc" onclick="actsort(this.id)">Active</a>
        </th>
        <th style='width: 10%;'>Action</th>
    </tr>

    <?php

    if ($count->cc > 0) {
        $i = $offset;
        foreach ($dt as $r) {
            $pic = $this->library->picUrl($r->pic, $r->url_pic, FDPLAYER, 'small');

            ?>
            <tr>
                <td class="center">
                    <input type='checkbox' name='selected[]' value='<?= $r->id_player ?>' class='ctab'>
                </td>
                <td class="center">
                    <div class='picproduct'>
                        <span style='background-image: url("<?= $pic; ?>");'></span>
                    </div>
                </td>
                <td>
                    <?=  $r->name.'<br>Position : '.$r->position_a; ?>
                </td>
                <td class="center capital hd-mobile">
                    <?= $r->club; ?>
                </td>
                <td class="center capital hd-mobile">
                    <?= $this->enum->active_string($r->is_active); ?>
                </td>
                <td class="center">
                    <a class='btn_action mg-r5' href='javascript:void(0)'
                       onclick="actmenu('football/playercareer/view/?id=<?= $r->id_player . $sv->idsub; ?>')" title='View'>
                        <i class='fa fa-search fa-fw'></i>
                    </a>
                    <a class='btn_action' href='javascript:void(0)'
                       onclick="openform('football/player/edit/<?= $r->id_player . $sv->idstay; ?>')" title='Edit'>
                        <i class='fa fa-edit fa-fw'></i>
                    </a>
                    <a class='btn_action' href='javascript:void(0)'
                       onclick="deleteid('football/player/delete/<?= $r->id_player . $sv->idstay; ?>')" title='Remove'>
                        <i class='fa fa-minus-square fa-fw'></i>
                    </a>
                </td>
            </tr>
            <?php

            $i++;
        }
    } else {
        echo "<tr><td colspan=6 style='text-transform: none;'>Data is not available</td></tr>";
    }

    ?>
</table>
