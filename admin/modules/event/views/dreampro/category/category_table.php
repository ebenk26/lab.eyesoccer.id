<table id='routertable'>
    <tr>
        <div id='showsort' value='event/category/search'></div>
        <th style='width: 5%;'>
            <input type='checkbox' name='checkall' id='checkall' onclick='actcheckall(this.id);'>
        </th>
        <th style='width: 5%;'>
            <?php $id = 'id_event_category'; ?>
            <a href="javascript:void(0)" class='csort' id="<?php echo $id; ?>" val="desc" onclick="actsort(this.id)">No</a>
        </th>
        <th style="text-align: left;">
            <?php $name = 'category_name'; ?>
            <a href="javascript:void(0)" class='csort' id="<?php echo $name; ?>" val="desc" onclick="actsort(this.id)">Name</a>
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
            echo "<tr>";
            echo "<td class='center'><input type='checkbox' name='selected[]' value='" . $r->$id . "' class='ctab'></td>";
            echo "<td class='center'>" . $i . "</td>";
            echo "<td>" . $r->$name . "</td>";
            echo "<td class='center'>";
              echo "<a class='btn_action' href='javascript:void(0)' onclick=\"openform('event/category/edit/". $r->$id ."$sv->idstay')\" title='Edit'><i class='fa fa-edit fa-fw'></i></a>
                    <a class='btn_action' href='javascript:void(0)' onclick=\"deleteid('event/category/delete/". $r->$id ."$sv->idstay')\" title='Remove'><i class='fa fa-minus-square fa-fw'></i></a>
                 </td>";
            echo "</tr>";
            
            $i++;
        }
    } else {
        echo "<tr><td colspan=4 style='text-transform: none;'>Data is not available</td></tr>";
    }
    
    ?>
</table>
