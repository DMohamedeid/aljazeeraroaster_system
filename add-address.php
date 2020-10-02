<?php
include("public/site-url.php");

if (empty($_COOKIE['client_id'])) {
    header("Location:" . $site_url . "/login.php");
}

include("include/header.php");
include("include/nav-bar.php");
?>
<style>

    .w3-green, .w3-hover-green:hover {
        color: #fff!important;
        background-color: green!important;
    }
    .w3-error, .w3-hover-green:hover {
        color: #fff!important;
        background-color: #af4c5e!important;
    }
    h3{
        text-align: center;
    }
    p{
        text-align: center;
    }
    .w3-panel {
        padding: 1.01em 16px;
    }
</style>

<!-- start bread -->
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="Aljazeera.html">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">My Profile</li>
        </ol>
    </nav>
</div>

<div class="main-title">
    <div class="container">
        <h3>My Profile</h3>
    </div>
</div>


<div class="container">
    <hr>
</div>

<!--Start Info-->
<div class="info">
    <div class="container">
        <!--start aside-->
        <aside>
            <div class="container">
                <ul class="list-unstyled">
                    <li><a href="Account-Info.html">Account Info</a></li>
                    <hr>
                    <li class="active"><a href="Save-Address.html">Saved Address</a></li>
                    <hr>
                    <li><a href="My-order.html">My Orders</a></li>
                    <hr>
                    <li><a href="My-favourite.html">My favourite</a></li>
                    <hr>
                </ul>
            </div>
        </aside>

        <!--start address-->
        <div class="add-address">
            <div class="container">
                <div class="add-new">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn exe" data-toggle="modal" data-target="#exampleModal">
                        Add New Address
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form>
                                        <div class="form-group">
                                            <label class="pl-2">Phone Number</label>
                                            <input type="text" class="form-control" placeholder="77777 76687 956">
                                        </div>
                                        <div class="form-group">
                                            <label class="pl-2">Area</label>
                                            <input type="text" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label class="pl-2">Block</label>
                                            <input type="text" class="form-control">
                                        </div>
                                        <div class="form-row">
                                            <div class="col">
                                                <label class="pl-2">Road</label>
                                                <input type="text" class="form-control">
                                            </div>
                                            <div class="col">
                                                <label class="pl-2">Floor No</label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col">
                                                <label class="pl-2">Apartment No</label>
                                                <input type="text" class="form-control">
                                            </div>
                                            <div class="col">
                                                <label class="pl-2">Flat Or Office</label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="pl-2">Additional Direction</label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn slov" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn slov">Save changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="frist">
                    <div class="second">
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <h4 class="pb-3">Sara Saleh</h4>
                                <div class="addres-spa pb-3">
                                    <div class="icon-one">
                                        <i class="fas fa-home"></i><span>Elmanama, Umm Al Nassan Ave</span>
                                    </div>
                                    <br>
                                    <div class="icon-two">
                                        <i class="fas fa-phone"></i><span>987773737881</span>
                                    </div>
                                </div>
                                <div class="main-link">
                                    <a href="#">Edit</a>
                                    <a href="#">Delete</a>
                                </div>
                                <div class="save">
                                    <button type="submit" class="btn-lg wow fadeInUp" data-wow-duration="1.5s" data-wow-delay=".5s" data-wow-offest="300">Save</button>
                                </div> 
                            </div>
                            <div class="col-md-6 col-12 adden">
                                <button type="submit" class="btn-lg wow fadeInRightBig" data-wow-duration="1.5s" data-wow-delay=".5s" data-wow-offest="100">Delivers to this address</button>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>

<div class="clearfix"></div>



<?php include("include/footer.php"); ?>
<script>
    $("#address-save").on('click', function () {
        var ths_form = $('#saveaddress');
        if (ths_form.valid()) {
            ths_form.submit();
        }
    });
</script>
