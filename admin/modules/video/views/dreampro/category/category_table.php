<table id='routertable'>
    <tr>
        <div id='showsort' value='video/category/search'></div>
        <th style='width: 5%;'>
            <input type='checkbox' name='checkall' id='checkall' onclick='actcheckall(this.id);'>
        </th>
        <th style='width: 5%;'>
            <a href="javascript:void(0)" class='csort' id="category_eyetube_id" val="desc" onclick="actsort(this.id)">No</a>
        </th>
        <th>
            <a href="javascript:void(0)" class='csort' id="category_name" val="desc" onclick="actsort(this.id)">Name</a>
        </th>
        <th style='width: 12%;'>Action</th>
    </tr>
    
    <?php
    
    if($count->cc > 0)
    {
        $sv = $this->library->sub_view();

        $i= $offset;
        foreach($dt as $r)
        {
            echo "<tr>";
            echo "<td class='center'><input type='checkbox' name='selected[]' value='" . $r->category_eyetube_id . "' class='ctab'></td>";
            echo "<td class='center'>" . $i . "</td>";
            echo "<td>" . $r->category_name . "</td>";
            echo "<td class='center'>";
                    if(empty($_GET['id']))
                    {
                        echo "<a class='btn_action mg-r5' href='javascript:void(0)' onclick=\"actmenu('video/category/view/?id=". $r->category_eyetube_id.$sv->idsub ."')\" title='Subview'><i class='fa fa-search fa-fw'></i></a>";
                    }
              echo "<a class='btn_action' href='javascript:void(0)' onclick=\"openform('video/category/edit/". $r->category_eyetube_id ."$sv->idstay')\" title='Edit'><i class='fa fa-edit fa-fw'></i></a>
                    <a class='btn_action' href='javascript:void(0)' onclick=\"deleteid('video/category/delete/". $r->category_eyetube_id ."$sv->idstay')\" title='Remove'><i class='fa fa-minus-square fa-fw'></i></a>
                 </td>";
            echo "</tr>";
            
            $i++;
        }
    } else {
        echo "<tr><td colspan=4 style='text-transform: none;'>Data is not available</td></tr>";
    }
    
    ?>
</table>
