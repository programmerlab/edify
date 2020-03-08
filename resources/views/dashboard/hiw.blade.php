<!DOCTYPE html>
<html>

@include('dashboard.partials.head')
<style>
        
/*  SECTIONS  */
.section {
  min-height: 100vh;
  color: #fff;
  padding: 2em;
  background: #363c42;
}

@media all and (min-width: 640px) {
  .section {
    padding: 4em;
  }
}
@media all and (min-width: 960px) {
  .section {
    padding: 6em;
  }
}
/*  SPLIT VISION  */
.split-vision {
  overflow: hidden;
}

.split-vision .column .content {
  max-width: 540px;
  padding-top: 1em;
  padding-bottom: 1em;
  margin-right: auto;
  margin-left: auto;
  position: relative;
  z-index: 2;
}

@media all and (min-width: 800px) {
  .split-vision {
    display: -webkit-box;
    display: flex;
    -webkit-box-align: center;
            align-items: center;
  }

  .split-vision .column {
    width: 50%;
  }

  .split-vision .column .content {
    padding-right: 1em;
    padding-left: 20%;
    margin-right: -10%;
  }
}
@media all and (min-width: 960px) {
  .split-vision .column .content {
    margin-right: 0;
  }

  .split-vision.reverse .column .content {
    margin-left: 0;
  }
}
/*  PROCESS  */
.process {
  width: 100%;
  max-width: none;
}

.process .discover,
.process .design,
.process .implement,
.process .develop,
.process .deliver {
  opacity: 0.8;
  -webkit-transform: scaleY(0);
          transform: scaleY(0);
  -webkit-transform-origin: 50% 100%;
          transform-origin: 50% 100%;
  -webkit-transition: opacity 0.25s;
  transition: opacity 0.25s;
}

.process.js-animate .discover,
.process.js-animate .design,
.process.js-animate .implement,
.process.js-animate .develop,
.process.js-animate .deliver {
  -webkit-animation: grow-up 1s forwards;
          animation: grow-up 1s forwards;
}

.process.js-animate .discover {
  -webkit-animation-delay: 0.25s;
          animation-delay: 0.25s;
}

.process.js-animate .design {
  -webkit-animation-delay: 0.5s;
          animation-delay: 0.5s;
}

.process.js-animate .implement {
  -webkit-animation-delay: 0.75s;
          animation-delay: 0.75s;
}

.process.js-animate .develop {
  -webkit-animation-delay: 1s;
          animation-delay: 1s;
}

.process.js-animate .deliver {
  -webkit-animation-delay: 1.25s;
          animation-delay: 1.25s;
}

@-webkit-keyframes grow-up {
  0% {
    -webkit-transform: scaleY(0);
            transform: scaleY(0);
  }
  50% {
    -webkit-transform: scaleY(1.1);
            transform: scaleY(1.1);
  }
  80%,
		100% {
    -webkit-transform: scaleY(1);
            transform: scaleY(1);
  }
}

@keyframes grow-up {
  0% {
    -webkit-transform: scaleY(0);
            transform: scaleY(0);
  }
  50% {
    -webkit-transform: scaleY(1.1);
            transform: scaleY(1.1);
  }
  80%,
		100% {
    -webkit-transform: scaleY(1);
            transform: scaleY(1);
  }
}
.process-details {
  max-width: 1440px;
  padding: 2em;
  margin-right: auto;
  margin-left: auto;
}

.process-details .discover,
.process-details .design,
.process-details .implement,
.process-details .develop,
.process-details .deliver {
  max-width: 480px;
  padding: 1em 0;
  margin-right: auto;
  margin-left: auto;
  -webkit-transition: opacity 0.25s;
  transition: opacity 0.25s;
}

.process-details .discover .heading,
.process-details .design .heading,
.process-details .implement .heading,
.process-details .develop .heading,
.process-details .deliver .heading {
  font-weight: 700;
}

.process-details .discover .heading::after,
.process-details .design .heading::after,
.process-details .implement .heading::after,
.process-details .develop .heading::after,
.process-details .deliver .heading::after {
  width: 40px;
  height: 4px;
  margin-top: 0.25em;
  display: block;
  content: '';
}

.process-details .discover .heading::after {
  background: #50b1aa;
}

.process-details .design .heading::after {
  background: #f57a73;
}

.process-details .implement .heading::after {
  background: #ffb566;
}

.process-details .develop .heading::after {
  background: #43c0e6;
}

.process-details .deliver .heading::after {
  background: #60666a;
}

@media all and (min-width: 800px) {
  .process-details {
    display: -webkit-box;
    display: flex;
    flex-wrap: wrap;
    -webkit-box-pack: center;
            justify-content: center;
  }

  .process-details .discover,
  .process-details .design,
  .process-details .implement,
  .process-details .develop,
  .process-details .deliver {
    width: 50%;
    padding-right: 1em;
    padding-left: 1em;
  }

  .process-details .discover {
    -webkit-box-ordinal-group: 2;
            order: 1;
  }

  .process-details .design {
    margin-right: 0;
    -webkit-box-ordinal-group: 5;
            order: 4;
  }

  .process-details .implement {
    -webkit-box-ordinal-group: 3;
            order: 2;
  }

  .process-details .develop {
    margin-left: 0;
    -webkit-box-ordinal-group: 6;
            order: 5;
  }

  .process-details .deliver {
    -webkit-box-ordinal-group: 4;
            order: 3;
  }
}
@media all and (min-width: 800px) {
  .process-details .discover,
  .process-details .design,
  .process-details .implement,
  .process-details .develop,
  .process-details .deliver {
    width: 33.3334%;
  }
}
@media all and (min-width: 1280px) {
  .process-details .discover,
  .process-details .design,
  .process-details .implement,
  .process-details .develop,
  .process-details .deliver {
    padding-right: 2em;
    padding-left: 2em;
  }
}

.hiw p{
    margin: 15px 0 10px;
}

    </style>
<body class="theme-edify1">

@include('dashboard.partials.header')

<section>

@include('dashboard.partials.sidebar')

</section>

<section class="content">
        <div class="container-fluid">

        <div class="card hiw">
                <div class="">
                    <section class="section grey">
                        <div class="split-vision">
                            <div class="column column-left">
                                <div class="content">
                                    <h1 class="numbered">How it works</h1>
                                </div>
                            </div>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="process js-animate" width="960" height="120" viewBox="0 0 960 120">
                            <g opacity="0.8">
                                <polygon class="design" fill="#F57A73" points="0,120 144,101 298,36 355,43 403,25 480,72 780,120"/>
                                <polygon class="discover" fill="#50B1AA" points="0,120 67,47 144,75 261,79 297,107 469,120"/>
                                <polygon class="implement" fill="#FFB566" points="345,120 385,105 508,29 558,68 614,88 692,89 835,120"/>
                                <polygon class="deliver" fill="#60666A" points="577,120 788,29 898,60 960,120"/>
                                <polygon class="develop" fill="#43C0E6" points="393,120 538,85 624,14 681,25 788,87 922,120"/>
                            </g>
                        </svg>
                        <div class="process-details">
                            <div class="design">
                                <div class="heading">DESIGN</div>
                                <p>Craft a purposeful design to reflect the objectives and indicate the direction for the entire portfolio. <br>[My Post]</p>
                            </div>
                            <div class="discover">
                                <div class="heading">DISCOVER</div>
                                <p>Post your creatively designed pictures. Users choses the editor based on their profile and portfolio of uploaded pictures. <br>[My Post]</p>
                            </div>
                            <div class="implement">
                                <div class="heading">IMPLEMENT</div>
                                <p>Download pictures given by customer and EDIFY them. <br>[My Orders]</p>
                            </div>
                            <div class="develop">
                                <div class="heading">DEVELOP</div>
                                <p>Incorporate implementation and technical components into a highly functional system, ready for review. <br>[My Orders]</p>
                            </div>
                            <div class="deliver">
                                <div class="heading">DELIVER</div>
                                <p>Get feedback for your finished design and after review upload it to get paid.</p>
                            </div>
                        </div>
                    </section>
                </div>
            </div>

        </div>
</section>

@include('dashboard.partials.footer_links')
<script>
        
        var processGraphs = document.querySelectorAll('.process polygon');
        var processDetails = document.querySelectorAll('.process-details > div');
        var processGraphMouseover = function (event) {
            for (var pg = 0, pgl = processGraphs.length; pg < pgl; pg++) {
                if (processGraphs[pg] === event.target && event.type === 'mouseover') {
                    processGraphs[pg].style.opacity = 1;
                } else {
                    processGraphs[pg].style.opacity = 0.5;
                }
            }
            for (pd = 0, pdl = processDetails.length; pd < pdl; pd++) {
                if (processDetails[pd].classList.contains(event.target.getAttribute('class')) && event.type === 'mouseover') {
                    processDetails[pd].style.opacity = 1;
                } else {
                    processDetails[pd].style.opacity = 0.5;
                }
            }
        };
        var processGraphMouseout = function (event) {
            for (var pg = 0, pgl = processGraphs.length; pg < pgl; pg++) {
                processGraphs[pg].removeAttribute('style');
            }
            for (pd = 0, pdl = processDetails.length; pd < pdl; pd++) {
                processDetails[pd].removeAttribute('style');
            }
        };
        for (var pg = 0, pgl = processGraphs.length; pg < pgl; pg++) {
            processGraphs[pg].addEventListener('mouseover', processGraphMouseover);
            processGraphs[pg].addEventListener('mouseout', processGraphMouseout);
        }
            </script>
</body>

</html>
