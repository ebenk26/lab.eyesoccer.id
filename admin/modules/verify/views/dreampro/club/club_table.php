<table id='routertable'>
    <tr>
        <div id='showsort' value='store/search'></div>
        <th style='width: 5%;'>
            <input type='checkbox' name='checkall' id='checkall' onclick='actcheckall(this.id);'>
        </th>
        <th style='width: 5%;'>
            <a href="javascript:void(0)" class='csort' id="id" val="desc" onclick="actsort(this.id)">No</a>
        </th>
        <th class='hd-mobile' style='width: 15%;'>
            <a href="javascript:void(0)" class='csort' id="name" val="desc" onclick="actsort(this.id)">Name</a>
        </th>
        <th class='hd-mobile' style='width: 15%;'>
            <a href="javascript:void(0)" class='csort' id="legal_pt" val="desc" onclick="actsort(this.id)">Legal PT</a>
        </th>
        <th class='hd-mobile' style='width: 15%;'>
            <a href="javascript:void(0)" class='csort' id="legal_pt" val="desc" onclick="actsort(this.id)">Legal Kemenham</a>
        </th>
        <th class='hd-mobile' style='width: 15%;'>
            <a href="javascript:void(0)" class='csort' id="legal_pt" val="desc" onclick="actsort(this.id)">NPWP</a>
        </th>
        <th class='hd-mobile' style='width: 15%;'>
            <a href="javascript:void(0)" class='csort' id="legal_pt" val="desc" onclick="actsort(this.id)">Legal Dirut</a>
        </th>
        <th class='hd-mobile' style='width: 10%;'>
            <a href="javascript:void(0)" class='csort' id="created_date" val="desc" onclick="actsort(this.id)">Regist Date</a>
        </th>
        <th style='width: 10%;'>Action</th>
    </tr>
    
    <?php
    $id = 'id_club';
    if($count->cc > 0)
    {
        $sv = $this->library->sub_view();

        $i= $offset;
        foreach($dt as $r)
        {
            // $pic_pt = $this->library->picUrl($r->url_pt, 'eyeprofile', 'thumb');
        ?>
            <tr>
                <td class='center'>
                    <input type='checkbox' name='selected[]' value='<?= $r->$id ?>' class='ctab'>
                </td>
                <td class="center">
                    <?= $i; ?>
                </td>
                <td class='center'>
                    <?= $r->name; ?>
                </td>
                <td class='center'> 
                    <div class='picproduct'>
                        <a href="<?= $r->url_pt; ?>" target="_blank">
                            <span style='background-image: url("<?= $r->url_pt; ?>");'></span>
                        </a>
                    </div>
                </td>
                <td class='center'> 
                    <div class='picproduct'>
                        <a href="<?= $r->url_kemenham; ?>" target="_blank">
                            <span style='background-image: url("<?= $r->url_kemenham; ?>");'></span>
                        </a>
                    </div>
                </td>
                <td class='center'> 
                    <div class='picproduct'>
                        <a href="<?= $r->url_npwp; ?>" target="_blank">
                            <span style='background-image: url("<?= $r->url_npwp; ?>");'></span>
                        </a>
                    </div>
                </td>
                <td class='center'> 
                    <div class='picproduct'>
                        <a href="<?= $r->url_dirut; ?>" target="_blank">
                            <span style='background-image: url("<?= $r->url_dirut; ?>");'></span>
                        </a>
                    </div>
                </td>
                <td class='center'>
                    <?= $r->date_create; ?>
                </td>
                <td class="center">
                    <a class='btn_action' href='javascript:void(0)'
                    onclick="openform('verify/club/verifying/<?= $r->$id.$sv->idstay; ?>')" title='Waiting Verification'> 
                        <i class='fa fa-check-square-o fa-fw'></i> 
                    </a>
                    <a class='btn_action' href='javascript:void(0)'
                    onclick="deleteid('verify/club/delete/<?= $r->$id.$sv->idstay; ?>')" title='Remove'> 
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
