<table id='routertable'>
    <tr>
        <div id='showsort' value='football/official/search'></div>
        <th style='width: 5%;'>
            <input type='checkbox' name='checkall' id='checkall' onclick='actcheckall(this.id);'>
        </th>
        <th style='width: 15%;'>
            <a href="javascript:void(0)" class='csort' id="id_official" val="desc" onclick="actsort(this.id)">Images</a>
        </th>
        <th>
            <a href="javascript:void(0)" class='csort' id="name" val="desc" onclick="actsort(this.id)">Official Detail</a>
        </th>
        <th class='hd-mobile' style='width: 20%;'>
            <a href="javascript:void(0)" class='csort' id="club" val="desc" onclick="actsort(this.id)">Club</a>
        </th>
        <th style='width: 10%;'>Action</th>
    </tr>

    <?php

    if ($count->cc > 0) {
        $sv = $this->library->sub_view();

        $i = $offset;
        foreach ($dt as $r) {
            $pic = $this->library->picUrl($r->pic, $r->url_pic, FDOFFICIAL, 'small');
            
            ?>
            <tr>
                <td class="center">
                    <input type='checkbox' name='selected[]' value='<?= $r->id_official ?>' class='ctab'>
                </td>
                <td class="center">
                    <div class='picproduct'>
                        <span style='background-image: url("<?= $pic; ?>");'></span>
                    </div>
                </td>
                <td>
                    <?= $r->name.'<br>Position : '.$r->position.'<br>License : '.$r->license; ?>
                </td>
                <td class="center">
                    <?= $r->club; ?>
                </td>
                <td class="center">
                    <a class='btn_action' href='javascript:void(0)'
                       onclick="openform('football/official/edit/<?= $r->id_official . $sv->idstay; ?>')" title='Edit'>
                        <i class='fa fa-edit fa-fw'></i>
                    </a>
                    <a class='btn_action' href='javascript:void(0)'
                       onclick="deleteid('football/official/delete/<?= $r->id_official . $sv->idstay; ?>')" title='Remove'>
                        <i class='fa fa-minus-square fa-fw'></i>
                    </a>
                </td>
            </tr>
            <?php

            $i++;
        }
    } else {
        echo "<tr><td colspan=5 style='text-transform: none;'>Data is not available</td></tr>";
    }

    ?>
</table>
