<?php
echo \Domus\Rendering\TwigRenderer::render('website-content.twig',(new \Domus\ViewModel\Website('archive'))->getContext());
