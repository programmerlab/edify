<!DOCTYPE html>
<html>

@include('dashboard.partials.head')
<style>
        .postUnit{
            height: 200px;
        }
        .postUnit .postimg{
            background-size: cover;
            height: calc(100% - 20px);
            width: calc(100% - 20px);
            background-position: center;
            position: absolute;
            top: 10px;
            left: 10px;
            transition: 0.3s all ease;
            border-radius: 4px;
        }
        .postimgAfter{
            opacity: 0;
        }
        .switchIcon{
            position: absolute;
            top: 5px;
            right: 5px;
            color: white;
            background-color: rgba(0, 0, 0, 0.4);
            z-index: 9;
            cursor: pointer;
            padding: 5px;
            border-radius: 50%;
        }
        .switchIcon:hover + .postimgAfter{
            opacity: 1;
        }
    </style>
<body class="theme-edify1">

@include('dashboard.partials.header')

<section>

@include('dashboard.partials.sidebar')

</section>

<section class="content">
        <div class="container-fluid">

        <div class="card">
                <div class="header">
                    <h2>Posts</h2>
                </div>
                <div class="body">

                    <div class="container-fluid">
                        <div class="postWrap">
                            <div class="col-xs-6 col-sm-4 col-md-3 postUnit">
                                <div style="background-image: url(https://s.ftcdn.net/v2013/pics/all/curated/RKyaEDwp8J7JKeZWQPuOVWvkUjGQfpCx_cover_580.jpg?r=1a0fc22192d0c808b8bb2b9bcfbf4a45b1793687)" class="postimg" > </div>
                                <label class="material-icons switchIcon">switch_camera</label>
                                <div style="background-image: url(https://lh3.googleusercontent.com/proxy/60qxBqw-2bfsYPdJGdtXobDhK5ONPcWbBpjo7zHz2avbyCOKQDpY01GuktFaeHrdgfx00ihUysde4RQezgQfzss-Pgwr2Du5UQ91Vg5B_1ujRCSeZ_VsGx2fxSzs7lr2vBm_HSfix10)"class="postimg postimgAfter" > </div>
                            </div>
                            <div class="col-xs-6 col-sm-4 col-md-3 postUnit">
                                <div style="background-image: url(https://s.ftcdn.net/v2013/pics/all/curated/RKyaEDwp8J7JKeZWQPuOVWvkUjGQfpCx_cover_580.jpg?r=1a0fc22192d0c808b8bb2b9bcfbf4a45b1793687)" class="postimg" > </div>
                                <label class="material-icons switchIcon">switch_camera</label>
                                <div style="background-image: url(https://lh3.googleusercontent.com/proxy/60qxBqw-2bfsYPdJGdtXobDhK5ONPcWbBpjo7zHz2avbyCOKQDpY01GuktFaeHrdgfx00ihUysde4RQezgQfzss-Pgwr2Du5UQ91Vg5B_1ujRCSeZ_VsGx2fxSzs7lr2vBm_HSfix10)"class="postimg postimgAfter" > </div>
                            </div>
                            <div class="col-xs-6 col-sm-4 col-md-3 postUnit">
                                <div style="background-image: url(https://s.ftcdn.net/v2013/pics/all/curated/RKyaEDwp8J7JKeZWQPuOVWvkUjGQfpCx_cover_580.jpg?r=1a0fc22192d0c808b8bb2b9bcfbf4a45b1793687)" class="postimg" > </div>
                                <label class="material-icons switchIcon">switch_camera</label>
                                <div style="background-image: url(https://lh3.googleusercontent.com/proxy/60qxBqw-2bfsYPdJGdtXobDhK5ONPcWbBpjo7zHz2avbyCOKQDpY01GuktFaeHrdgfx00ihUysde4RQezgQfzss-Pgwr2Du5UQ91Vg5B_1ujRCSeZ_VsGx2fxSzs7lr2vBm_HSfix10)"class="postimg postimgAfter" > </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
</section>

@include('dashboard.partials.footer_links')
</body>

</html>
