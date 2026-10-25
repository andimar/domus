<?php
namespace Domus\ViewModel\Common;
final class ComponentData {
    public function __construct(public string $name, public mixed $data = []) {}
}
