<table id='routertable'>
    <tr>
        <div id='showsort' value='video/search'></div>
        <th style='width: 5%;'>
            <input type='checkbox' name='checkall' id='checkall' onclick='actcheckall(this.id);'>
        </th>
        <th style='width: 15%;'>
            <a href="javascript:void(0)" class='csort' id="eyetube_id" val="desc" onclick="actsort(this.id)">No</a>
        </th>
        <th>
            <a href="javascript:void(0)" class='csort' id="title" val="desc" onclick="actsort(this.id)">Title</a>
        </th>
        <th class='hd-mobile' style='width: 15%;'>
            <a href="javascript:void(0)" class='csort' id="category_name" val="desc" onclick="actsort(this.id)">Category</a>
        </th>
        <th style='width: 10%;'>Action</th>
    </tr>
    
    <?php
    
    if($count->cc > 0)
    {
        $i= $offset;
        foreach($dt as $r)
        {
            $pic = $this->library->picUrl($r->thumb, $r->url_thumb, 'eyetube', 'thumb');

            echo "<tr>";
            echo "<td class='center'><input type='checkbox' name='selected[]' value='" . $r->eyetube_id . "' class='ctab'></td>";
            echo "<td class='center'><div class='picproduct'><span style='background-image: url(" . $pic . ");'></span></div></td>";
            echo "<td>" . $r->title . "<br>Author : " . $r->user_fname . "<br>Views : $r->tube_view</td>";
            echo "<td class='center capital hd-mobile'>" . $r->category_name . "</td>";
            echo "<td class='center'>
                    <a class='btn_action' href='javascript:void(0)' onclick=\"openform('video/edit/". $r->eyetube_id ."')\" title='Edit'><i class='fa fa-edit fa-fw'></i></a>
                    <a class='btn_action' href='javascript:void(0)' onclick=\"deleteid('video/delete/". $r->eyetube_id ."')\" title='Remove'><i class='fa fa-minus-square fa-fw'></i></a>
                 </td>";
            echo "</tr>";
            
            $i++;
        }
    } else {
        echo "<tr><td colspan=5 style='text-transform: none;'>Data is not available</td></tr>";
    }
    
    ?>
</table>
