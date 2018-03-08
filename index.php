<?php

/*
* Name: FS
* Author: github.com/ptudweb-lab/project
* Version: VERSION.txt
*/
define('_IN_FS', 1);
require_once('system/core.php');
require_once('system/head.php');
?>
<div class="row">
            <!-- Danh muc san pham -->
            <div class="col-4">
                <div class="list-group">
                    <a href="#" class="list-group-item list-group-item-action">
                        <i class="fas fa-bullhorn"></i> Thông tin 1</a>
                    <a href="#" class="list-group-item list-group-item-action">
                        <i class="fas fa-bullhorn"></i> Thông tin 2</a>
                    <a href="#" class="list-group-item list-group-item-action">
                        <i class="fas fa-bullhorn"></i> Thông tin 3</a>
                    <a href="#" class="list-group-item list-group-item-action">
                        <i class="fas fa-bullhorn"></i> Thông tin 4</a>
                </div>
            </div>
            <!-- Banner -->
            <div class="col-8">
                <div id="demo" class="carousel slide" data-ride="carousel">

                    <!-- Indicators -->
                    <ul class="carousel-indicators">
                        <li data-target="#demo" data-slide-to="0" class="active"></li>
                        <li data-target="#demo" data-slide-to="1"></li>
                    </ul>

                    <!-- The slideshow -->
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="img/banner/banner-1.jpg" alt="Banner 1" width="100%" height="500px">
                            <div class="carousel-caption">
                                <h3>Banner 1</h3>
                                <p>Đây là banner số 1</p>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="img/banner/banner-2.jpg" alt="Banner 2" width="100%" height="500px">
                            <div class="carousel-caption">
                                <h3>Banner 2</h3>
                                <p>Đây là banner số 2</p>
                            </div>
                        </div>
                    </div>

                    <!-- Left and right controls -->
                    <a class="carousel-control-prev" href="#demo" data-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </a>
                    <a class="carousel-control-next" href="#demo" data-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </a>

                </div>
            </div>
        </div>
        <hr/>
        <!-- Danh muc -->
        <div class="row">
            <div class="col-12">
                <div class="arrow bg-primary">
                    <div class="arrow-circle bg-success">
                        <i class="fas fa-plus-square"></i>
                    </div>
                    <div class="arrow-content">Sản phẩm mới</div>
                </div>
            </div>
        </div>
        <div class="row list-product">
            <div class="col-2">
                <div class="card">
                    <img class="card-img-top" src="img/noimage.png" alt="Product title">
                    <div class="card-body">
                        <h5 class="card-title">Tên sản phẩm</h5>
                        <p class="card-text">
                            <span class="fas fa-star star-checked"></span>
                            <span class="fas fa-star star-checked"></span>
                            <span class="fas fa-star star-checked"></span>
                            <span class="fas fa-star"></span>
                            <span class="fas fa-star"></span>
                            </br>
                            Giá: 0 VNĐ
                        </p>
                    </div>
                    <div class="card-footer">
                        <a href="#" class="btn btn-primary text-left" title="Thêm vào giỏ hàng">
                            <i class="fas fa-cart-plus"></i>
                        </a>
                        <a href="#" class="btn btn-primary text-right">
                            Chi tiết
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-2">
                <div class="card">
                    <img class="card-img-top" src="img/noimage.png" alt="Product title">
                    <div class="card-body">
                        <h5 class="card-title">Tên sản phẩm</h5>
                        <p class="card-text">
                            <span class="fas fa-star star-checked"></span>
                            <span class="fas fa-star star-checked"></span>
                            <span class="fas fa-star star-checked"></span>
                            <span class="fas fa-star"></span>
                            <span class="fas fa-star"></span>
                            </br>
                            Giá: 0 VNĐ
                        </p>
                    </div>
                    <div class="card-footer">
                        <a href="#" class="btn btn-primary text-left" title="Thêm vào giỏ hàng">
                            <i class="fas fa-cart-plus"></i>
                        </a>
                        <a href="#" class="btn btn-primary text-right">
                            Chi tiết
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-2">
                <div class="card">
                    <img class="card-img-top" src="img/noimage.png" alt="Product title">
                    <div class="card-body">
                        <h5 class="card-title">Tên sản phẩm</h5>
                        <p class="card-text">
                            <span class="fas fa-star star-checked"></span>
                            <span class="fas fa-star star-checked"></span>
                            <span class="fas fa-star star-checked"></span>
                            <span class="fas fa-star"></span>
                            <span class="fas fa-star"></span>
                            </br>
                            Giá: 0 VNĐ
                        </p>
                    </div>
                    <div class="card-footer">
                        <a href="#" class="btn btn-primary text-left" title="Thêm vào giỏ hàng">
                            <i class="fas fa-cart-plus"></i>
                        </a>
                        <a href="#" class="btn btn-primary text-right">
                            Chi tiết
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-2">
                <div class="card">
                    <img class="card-img-top" src="img/noimage.png" alt="Product title">
                    <div class="card-body">
                        <h5 class="card-title">Tên sản phẩm</h5>
                        <p class="card-text">
                            <span class="fas fa-star star-checked"></span>
                            <span class="fas fa-star star-checked"></span>
                            <span class="fas fa-star star-checked"></span>
                            <span class="fas fa-star"></span>
                            <span class="fas fa-star"></span>
                            </br>
                            Giá: 0 VNĐ
                        </p>
                    </div>
                    <div class="card-footer">
                        <a href="#" class="btn btn-primary text-left" title="Thêm vào giỏ hàng">
                            <i class="fas fa-cart-plus"></i>
                        </a>
                        <a href="#" class="btn btn-primary text-right">
                            Chi tiết
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-2">
                <div class="card">
                    <img class="card-img-top" src="img/noimage.png" alt="Product title">
                    <div class="card-body">
                        <h5 class="card-title">Tên sản phẩm</h5>
                        <p class="card-text">
                            <span class="fas fa-star star-checked"></span>
                            <span class="fas fa-star star-checked"></span>
                            <span class="fas fa-star star-checked"></span>
                            <span class="fas fa-star"></span>
                            <span class="fas fa-star"></span>
                            </br>
                            Giá: 0 VNĐ
                        </p>
                    </div>
                    <div class="card-footer">
                        <a href="#" class="btn btn-primary text-left" title="Thêm vào giỏ hàng">
                            <i class="fas fa-cart-plus"></i>
                        </a>
                        <a href="#" class="btn btn-primary text-right">
                            Chi tiết
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-2">
                <div class="card">
                    <img class="card-img-top" src="img/noimage.png" alt="Product title">
                    <div class="card-body">
                        <h5 class="card-title">Tên sản phẩm</h5>
                        <p class="card-text">
                            <span class="fas fa-star star-checked"></span>
                            <span class="fas fa-star star-checked"></span>
                            <span class="fas fa-star star-checked"></span>
                            <span class="fas fa-star"></span>
                            <span class="fas fa-star"></span>
                            </br>
                            Giá: 0 VNĐ
                        </p>
                    </div>
                    <div class="card-footer">
                        <a href="#" class="btn btn-primary text-left" title="Thêm vào giỏ hàng">
                            <i class="fas fa-cart-plus"></i>
                        </a>
                        <a href="#" class="btn btn-primary text-right">
                            Chi tiết
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-12">
                <div class="arrow bg-primary">
                    <div class="arrow-circle bg-success">
                        <i class="fas fa-fire"></i>
                    </div>
                    <div class="arrow-content">
                        <div class="btn-group">
                            <span>Sản phẩm bán chạy</span>
                            <a class="btn btn-primary dropdown-toggle dropdown-toggle-split" style="padding: 0px; margin: 2px;" data-toggle="dropdown">
                                <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item active" href="#">Sản phẩm bán chạy</a>
                                <a class="dropdown-item" href="#">Sản phẩm được đánh giá cao</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row list-product">
            <div class="col-2">
                <div class="card">
                    <img class="card-img-top" src="img/noimage.png" alt="Product title">
                    <div class="card-body">
                        <h5 class="card-title">Tên sản phẩm</h5>
                        <p class="card-text">
                            <span class="fas fa-star star-checked"></span>
                            <span class="fas fa-star star-checked"></span>
                            <span class="fas fa-star star-checked"></span>
                            <span class="fas fa-star"></span>
                            <span class="fas fa-star"></span>
                            </br>
                            Giá: 0 VNĐ
                        </p>
                    </div>
                    <div class="card-footer">
                        <a href="#" class="btn btn-primary text-left" title="Thêm vào giỏ hàng">
                            <i class="fas fa-cart-plus"></i>
                        </a>
                        <a href="#" class="btn btn-primary text-right">
                            Chi tiết
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-2">
                <div class="card">
                    <img class="card-img-top" src="img/noimage.png" alt="Product title">
                    <div class="card-body">
                        <h5 class="card-title">Tên sản phẩm</h5>
                        <p class="card-text">
                            <span class="fas fa-star star-checked"></span>
                            <span class="fas fa-star star-checked"></span>
                            <span class="fas fa-star star-checked"></span>
                            <span class="fas fa-star"></span>
                            <span class="fas fa-star"></span>
                            </br>
                            Giá: 0 VNĐ
                        </p>
                    </div>
                    <div class="card-footer">
                        <a href="#" class="btn btn-primary text-left" title="Thêm vào giỏ hàng">
                            <i class="fas fa-cart-plus"></i>
                        </a>
                        <a href="#" class="btn btn-primary text-right">
                            Chi tiết
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-2">
                <div class="card">
                    <img class="card-img-top" src="img/noimage.png" alt="Product title">
                    <div class="card-body">
                        <h5 class="card-title">Tên sản phẩm</h5>
                        <p class="card-text">
                            <span class="fas fa-star star-checked"></span>
                            <span class="fas fa-star star-checked"></span>
                            <span class="fas fa-star star-checked"></span>
                            <span class="fas fa-star"></span>
                            <span class="fas fa-star"></span>
                            </br>
                            Giá: 0 VNĐ
                        </p>
                    </div>
                    <div class="card-footer">
                        <a href="#" class="btn btn-primary text-left" title="Thêm vào giỏ hàng">
                            <i class="fas fa-cart-plus"></i>
                        </a>
                        <a href="#" class="btn btn-primary text-right">
                            Chi tiết
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-2">
                <div class="card">
                    <img class="card-img-top" src="img/noimage.png" alt="Product title">
                    <div class="card-body">
                        <h5 class="card-title">Tên sản phẩm</h5>
                        <p class="card-text">
                            <span class="fas fa-star star-checked"></span>
                            <span class="fas fa-star star-checked"></span>
                            <span class="fas fa-star star-checked"></span>
                            <span class="fas fa-star"></span>
                            <span class="fas fa-star"></span>
                            </br>
                            Giá: 0 VNĐ
                        </p>
                    </div>
                    <div class="card-footer">
                        <a href="#" class="btn btn-primary text-left" title="Thêm vào giỏ hàng">
                            <i class="fas fa-cart-plus"></i>
                        </a>
                        <a href="#" class="btn btn-primary text-right">
                            Chi tiết
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-2">
                <div class="card">
                    <img class="card-img-top" src="img/noimage.png" alt="Product title">
                    <div class="card-body">
                        <h5 class="card-title">Tên sản phẩm</h5>
                        <p class="card-text">
                            <span class="fas fa-star star-checked"></span>
                            <span class="fas fa-star star-checked"></span>
                            <span class="fas fa-star star-checked"></span>
                            <span class="fas fa-star"></span>
                            <span class="fas fa-star"></span>
                            </br>
                            Giá: 0 VNĐ
                        </p>
                    </div>
                    <div class="card-footer">
                        <a href="#" class="btn btn-primary text-left" title="Thêm vào giỏ hàng">
                            <i class="fas fa-cart-plus"></i>
                        </a>
                        <a href="#" class="btn btn-primary text-right">
                            Chi tiết
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-2">
                <div class="card">
                    <img class="card-img-top" src="img/noimage.png" alt="Product title">
                    <div class="card-body">
                        <h5 class="card-title">Tên sản phẩm</h5>
                        <p class="card-text">
                            <span class="fas fa-star star-checked"></span>
                            <span class="fas fa-star star-checked"></span>
                            <span class="fas fa-star star-checked"></span>
                            <span class="fas fa-star"></span>
                            <span class="fas fa-star"></span>
                            </br>
                            Giá: 0 VNĐ
                        </p>
                    </div>
                    <div class="card-footer">
                        <a href="#" class="btn btn-primary text-left" title="Thêm vào giỏ hàng">
                            <i class="fas fa-cart-plus"></i>
                        </a>
                        <a href="#" class="btn btn-primary text-right">
                            Chi tiết
                        </a>
                    </div>
                </div>
            </div>
        </div>

<?php require_once('system/foot.php'); ?>