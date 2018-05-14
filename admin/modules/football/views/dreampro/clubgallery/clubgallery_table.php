<table id='routertable'>
    <tr>
        <?php $sv = $this->library->sub_view(); ?>
        <div id='showsort' value='football/clubgallery/search<?php echo $sv->idstay; ?>'></div>
        <th style='width: 5%;'>
            <input type='checkbox' name='checkall' id='checkall' onclick='actcheckall(this.id);'>
        </th>
        <th>
            <a href="javascript:void(0)" class='csort' id="id_gallery" val="desc" onclick="actsort(this.id)">Image</a>
        </th>
        <th style='width: 40%;'>
            <a href="javascript:void(0)" class='csort' id="upload_date" val="desc" onclick="actsort(this.id)">Upload Date</a>
        </th>
        <th style='width: 10%;'>Action</th>
    </tr>
    
    <?php
    
    if($count->cc > 0)
    {
        $i= $offset;
        foreach($dt as $r)
        {
            $pic = $this->library->picUrl($r->pic, $r->url_pic, FDIMAGES, 'small');

            echo "<tr>";
            echo "<td class='center'><input type='checkbox' name='selected[]' value='" . $r->id_gallery . "' class='ctab'></td>";
            echo "<td class='center'><div class='picproduct'><span style='background-image: url(" . $pic . ");'></span></div></td>";
            echo "<td class='center capital'>" . date('d-m-Y H:i:s', strtotime($r->upload_date)) . "</td>";
            echo "<td class='center'>
                    <a class='btn_action' href='javascript:void(0)' onclick=\"deleteid('football/clubgallery/delete/". $r->id_gallery  . $sv->idstay ."')\" title='Remove'><i class='fa fa-minus-square fa-fw'></i></a>
                 </td>";
            echo "</tr>";
            
            $i++;
        }
    } else {
        echo "<tr><td colspan=4 style='text-transform: none;'>Data is not available</td></tr>";
    }
    
    ?>
</table>
