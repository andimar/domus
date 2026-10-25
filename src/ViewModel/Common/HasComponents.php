<?php
namespace Domus\ViewModel\Common;
trait HasComponents {
    protected array $context = [];
    protected function loadComponents(array $components, mixed $data = null): void {
        foreach ($components as $class) {
            if (!is_a($class, Component::class, true)) throw new \LogicException('Componente non valido');
            $result = (new $class($data, $this->context))->getData();
            if (array_key_exists($result->name, $this->context)) throw new \LogicException('Nome componente duplicato: ' . $result->name);
            $this->context[$result->name] = $result->data;
        }
    }
    public function getContext(): array { return $this->context; }
}
