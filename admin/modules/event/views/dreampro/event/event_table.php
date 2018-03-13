
<table id='routertable'>
    <tr>
        <div id='showsort' value='event/search'></div>
        <th style='width: 5%;'>
            <input type='checkbox' name='checkall' id='checkall' onclick='actcheckall(this.id);'>
        </th>
        <th style='width: 15%;'>
            <a href="javascript:void(0)" class='csort' id="id_event" val="desc" onclick="actsort(this.id)">No</a>
        </th>
        <th>
            <a href="javascript:void(0)" class='csort' id="title" val="desc" onclick="actsort(this.id)">Title</a>
        </th>
        <th class='hd-mobile' style='width: 15%;'>
            <a href="javascript:void(0)" class='csort' id="publish_on" val="desc" onclick="actsort(this.id)">Publish On</a>
        </th>
        <th style='width: 10%;'>Action</th>
    </tr>
    
    <?php
    
    if($count->cc > 0)
    {
        $i= $offset;
        foreach($dt as $r)
        {
            $pic = $this->library->picUrl($r->pic, $r->url_pic, 'eyevent', 'thumb');

            echo "<tr>";
            echo "<td class='center'><input type='checkbox' name='selected[]' value='" . $r->id_event . "' class='ctab'></td>";
            echo "<td class='center'><div class='picproduct'><span style='background-image: url(" . $pic . ");'></span></div></td>";
            echo "<td>" . $r->title . "<br>Author : " . $r->user_fname . "<br></td>";
            echo "<td class='center capital hd-mobile'>" . $r->publish_on . "</td>";
            echo "<td class='center'>
                    <a class='btn_action' href='javascript:void(0)' onclick=\"openform('event/edit/". $r->id_event ."')\" title='Edit'><i class='fa fa-edit fa-fw'></i></a>
                    <a class='btn_action' href='javascript:void(0)' onclick=\"deleteid('event/delete/". $r->id_event ."')\" title='Remove'><i class='fa fa-minus-square fa-fw'></i></a>
                 </td>";
            echo "</tr>";
            
            $i++;
        }
    } else {
        echo "<tr><td colspan=5 style='text-transform: none;'>Data is not available</td></tr>";
    }
    
    ?>
</table>
