        <div class="form-group">
            <label for="exampleFormControlSelect1">Danh sách thể loại</label>
            <select name="MaTL"  class="form-control" id="exampleFormControlSelect1">
                <?php foreach($data['category'] as $key => $value) {?>
                <option value="<?php echo $value['MaTL'] ?>" <?php if(isset($data['product'])) { if($data['product']['MaTL'] == $value['MaTL']) {
                    echo "selected"; }}
                ?> > 
                
                <?php echo $value['TenTheLoai'] ?></option>
                <?php }?>
            </select>
        </div>
        <div class="form-group">
            <label for="exampleFormControlSelect1">Danh sách tác giả</label>
            <select name="MaTG"  class="form-control" id="exampleFormControlSelect1">
                <?php foreach($data['author'] as $key => $value) {?>
                <option value="<?php echo $value['MaTG'] ?>" <?php if(isset($data['product'])) { if($data['product']['MaTG'] == $value['MaTG']) {
                    echo "selected"; }}
                ?> > 
                
                <?php echo $value['TenTG'] ?></option>
                <?php }?>
            </select>
        </div>

        <div class="form-group">
            <label for="exampleFormControlSelect1">Danh sách nhà xuất bản</label>
            <select name="MaNXB"  class="form-control" id="exampleFormControlSelect1">
                <?php foreach($data['publisher'] as $key => $value) {?>
                <option value="<?php echo $value['MaNXB'] ?>" <?php if(isset($data['product'])) {
                    if ($data['product']['MaNXB'] == $value['MaNXB']) {
                        echo "selected";
                    } 
                }
                ?> > 
                
                <?php echo $value['TenNXB'] ?></option>
                <?php }?>
            </select>
        </div>

       