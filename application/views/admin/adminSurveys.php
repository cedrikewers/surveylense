<div class="card bg-white">
    <div class="card-header">
        <div class="row">
            <div class="col-4 col-xl-4">
                Users
            </div>
            <div class="col-8 d-flex justify-content-end">
                <form class="form-inline my-2 my-lg-0" action="<?= site_url('admin/adminarea/surveys') ?>" method="post">
                    <input class="form-control mr-sm-2" name="search" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
            </div>
        </div>
    </div>
        <ul class="list-group list-group-flush">
        <?php
        foreach ($surveys_list as $data_item){
            echo '<li class="list-group-item">
                <div class="row row-cols-2">
                    <div class="col-4 col-xl-4">'.$data_item['name'].'</div>
                    <div class="col-8 d-flex justify-content-end">
                        '; if(1 == 1){
                            //echo '<span class="d-none d-sm-inline text-success">active</span>';
                            //echo '<a href="'.site_url('admin/modify/deactivateUser/'.$data_item['id']).'"style="margin-left: 5%;"><i class="fas fa-pen"></i><span class="d-none d-sm-inline">deactivate</span></a>';
                        }
                        else{
                            //echo '<span class="d-none d-sm-inline text-danger">inactive</span>';
                            //echo '<a href="'.site_url('admin/modify/activateUser/'.$data_item['id']).'"style="margin-left: 5%;"><i class="fas fa-pen"></i><span class="d-none d-sm-inline">activate</span></a>';
                        }
                        echo '
                        
                    </div> 
                </div>
            
            
            
            
            
                </li>';
        }

        ?>
    </ul>
</div>