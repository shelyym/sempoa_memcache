<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PageError
 *
 * @author User
 */
class PageError {

    public static function p404 ()
    {
        ?>
        <!-- Main content -->
        <section class="content">

            <div class="error-page">
                <h2 class="headline text-info"> 404</h2>

                <div class="error-content">
                    <h3><i class="fa fa-warning text-yellow"></i> Oops! Page not found.</h3>

                    <p>
                        We could not find the page you were looking for.
                        Meanwhile, you may <a href='<?= _SPPATH; ?>home'>return to home</a>
                        <!--or try using the search form.-->
                    </p>
                    <?/* <form class='search-form'>
                                <div class='input-group'>
                                    <input type="text" name="search" class='form-control' placeholder="Search"/>
                                    <div class="input-group-btn">
                                        <button type="submit" name="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                                    </div>
                                </div><!-- /.input-group -->
                            </form>*/
                    ?>
                </div>
                <!-- /.error-content -->
            </div>
            <!-- /.error-page -->

        </section><!-- /.content -->
    <?
    }
}
