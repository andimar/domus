<?php
namespace Domus\ViewModel\Common;
interface Component {
    public function __construct(mixed $data, array $context);
    public function getData(): ComponentData;
}
