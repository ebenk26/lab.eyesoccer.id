<table id='routertable'>
    <tr>
        <div id='showsort' value='football/competition/search'></div>
        <th style='width: 5%;'>
            <input type='checkbox' name='checkall' id='checkall' onclick='actcheckall(this.id);'>
        </th>
        <th style='width: 5%;'>
            <?php $id = 'id_player'; ?>
            <a href="javascript:void(0)" class='csort' id="<?php echo $id; ?>" val="desc" onclick="actsort(this.id)">No</a>
        </th>
        <th style="text-align: center;">
            <?php $pic = 'url_pic'; ?>
            <a href="javascript:void(0)" class='csort' id="<?php echo $pic; ?>" val="desc" onclick="actsort(this.id)">Photo</a>
        </th>
        <th style="text-align: center;">
            <?php $name = 'name'; ?>
            <a href="javascript:void(0)" class='csort' id="<?php echo $name; ?>" val="desc" onclick="actsort(this.id)">Name</a>
        </th>
        <th style="text-align: center;">
            <a href="javascript:void(0)" class='csort' id="club" val="desc" onclick="actsort(this.id)">Club</a>
        </th>
        <th style='width: 10%;'>Action</th>
    </tr>
    
    <?php
    
    if($count->cc > 0)
    {
        $sv = $this->library->sub_view();

        $i= $offset;
        foreach($dt as $r)
        {
    ?>
            <tr>
                <td class="center">
                    <input type='checkbox' name='selected[]' value='<?= $r->$id ?>' class='ctab'>
                </td>
                <td class="center">
                    <?= $i; ?>
                </td>
                <td class="center">
                    <div class='picproduct'> 
                        <span style='background-image: url("<?= $r->url_pic; ?>");'></span> 
                    </div>
                </td>
                <td class="center">
                    <?= $r->$name; ?>
                </td>
                <td class="center">
                    <?= $r->club; ?>
                </td>
                <td class="center">
                    <?php
                        echo "<a class='btn_action mg-r5' href='javascript:void(0)' onclick=\"actmenu('football/playercareer/view/?id=". $r->$id.$sv->idsub ."')\" title='Career'><i class='fa fa-briefcase fa-fw'></i></a>";
                    ?>
                    <a class='btn_action' href='javascript:void(0)'
                    onclick="openform('football/player/edit/<?= $r->$id.$sv->idstay; ?>')" title='Edit'> 
                        <i class='fa fa-edit fa-fw'></i> 
                    </a>
                    <a class='btn_action' href='javascript:void(0)'
                    onclick="deleteid('football/player/delete/<?= $r->$id.$sv->idstay; ?>')" title='Remove'> 
                        <i class='fa fa-minus-square fa-fw'></i> 
                    </a>
                </td>
            </tr>
    <?php
            $i++;
        }
    } else {
        echo "<tr><td colspan=4 style='text-transform: none;'>Data is not available</td></tr>";
    }
    
    ?>
</table>
