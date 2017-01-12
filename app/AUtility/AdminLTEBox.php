<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 11/17/15
 * Time: 3:05 PM
 */

class AdminLTEBox {

    public static function create($title,$content){

        ?>
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?=$title;?></h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body chart-responsive">
                <?=$content;?>
            </div>
            <!-- /.box-body -->
        </div>
        <?
    }

} 