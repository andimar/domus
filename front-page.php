<?php
echo \Domus\Rendering\TwigRenderer::render('website-home.twig',(new \Domus\ViewModel\Website('home'))->getContext());
