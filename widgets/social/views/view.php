<?php

use yii\helpers\Url;

?>

<div class="social-widgets relative hidden-xs">
    <div class="push40"></div>
    <div class="container">

        <div class="title-h1 white text-center weight900">Следи за нами в соцсетях</div>
        <div class="subtitle text-center white f18">– вступай в наши группы!</div>
        <div class="push15"></div>
        <div class="row">


            <div class="col-sm-6 col-md-3">
                <div class="element">
                    <!-- // OK widget //-->
                    <div id="ok_group_widget"></div>
                    <script>
                        !function (d, id, did, st) {
                            var js = d.createElement("script");
                            js.src = "https://connect.ok.ru/connect.js";
                            js.onload = js.onreadystatechange = function () {
                                if (!this.readyState || this.readyState == "loaded" || this.readyState == "complete") {
                                    if (!this.executed) {
                                        this.executed = true;
                                        setTimeout(function () {
                                            OK.CONNECT.insertGroupWidget(id,did,st);
                                        }, 0);
                                    }
                                }}
                            d.documentElement.appendChild(js);
                        }(document,"ok_group_widget","54740235780209",'{"width":360,"height":335}');
                    </script>
                    <!-- // End OK widget //-->
                </div>
            </div>


            <div class="col-sm-6 col-md-3">
                <div class="element">
                    <!-- vk-wrapper -->
                    <div id="vk_widget">
                        <div id="vk_groups"></div>
                    </div>
                    <script type="text/javascript" src="//vk.com/js/api/openapi.js?150"></script>

                    <!-- VK Widget -->
                    <div id="vk_groups"></div>
                    <script type="text/javascript" src="https://vk.com/js/api/openapi.js?116"></script>
                    <script>
                        function VK_Widget_Init() {
                            document.getElementById('vk_groups').innerHTML = "";
                            var vk_width = document.getElementById('vk_widget').clientWidth;
                            VK.Widgets.Group("vk_groups", {
                                mode: 0,
                                width: "auto",
                                height: "330",
                                color1: "FFFFFF",
                                color2: "00487F",
                                color3: "00487F"
                            }, 137904697);
                        }
                        ;
                        window.addEventListener('load', VK_Widget_Init, false);
                        window.addEventListener('resize', VK_Widget_Init, false);
                    </script>
                    <!-- / vk-wrapper -->
                </div>
            </div>


            <div class="col-sm-6 col-md-3">
                <div class="element">
                    <iframe src='/inwidget/index.php?width=370&inline=5&view=25&toolbar=false' scrolling='no'
                            frameborder='no' style='border:none;width:250px;height:335px;overflow:hidden;'></iframe>
                </div>
            </div>


            <div class="col-sm-6 col-md-3">
                <div class="element">
                    

                </div>
            </div>


        </div>
    </div>
    <div class="push35"></div>
</div>
