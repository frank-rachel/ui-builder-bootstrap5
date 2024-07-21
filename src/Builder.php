<?php

namespace Lagdo\UiBuilder\Bootstrap5;

use Lagdo\UiBuilder\Builder as AbstractBuilder;

class Builder extends AbstractBuilder
{
    use Traits\LayoutTrait;
    use Traits\ButtonTrait;
    use Traits\PanelTrait;
    use Traits\FormTrait;
    use Traits\MenuTrait;
    use Traits\TabTrait;
    use Traits\PaginationTrait;

    /**
     * @inheritDoc
     */
    public function addIcon(string $icon): self
    {
        if ($icon === 'remove') {
            $icon = 'x';
        } elseif ($icon === 'edit') {
            $icon = 'pencil';
        } elseif ($icon === 'ok') {
            $icon = 'check';
        }
        return $this->addHtml('<i class="bi bi-' . $icon . '"></i>');
    }

    /**
     * @inheritDoc
     */
    public function addCaret(): self
    {
        // Nothing to do.
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function checkbox(bool $checked = false, ...$arguments): self
    {
        $class = 'form-check-input';
        if ($this->builder->isInputGroup()) {
            $this->builder->createWrapper('div', ['class' => 'input-group-text']);
            $class .= ' mt-0';
        }
        parent::checkbox($checked, ...$arguments);
        $this->builder->prependClass($class);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function radio(bool $checked = false, ...$arguments): self
    {
        $class = 'form-check-input';
        if ($this->builder->isInputGroup()) {
            $this->builder->createWrapper('div', ['class' => 'input-group-text']);
            $class .= ' mt-0';
        }
        parent::radio($checked, ...$arguments);
        $this->builder->prependClass($class);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function text(...$arguments): self
    {
        // A label in an input group must be wrapped into a span with class "input-group-addon".
        // Check the parent scope.
        $isInGroup = ($this->builder->isInputGroup());
        $this->builder->createScope('span', $arguments);
        if ($isInGroup) {
            $this->builder->prependClass('input-group-text');
        }
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function inputGroup(...$arguments): self
    {
        $this->builder->createScope('div', $arguments);
        $this->builder->prependClass('input-group mb-3');
        $this->builder->scope()->isInputGroup = true;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function table(bool $responsive, string $style = '', ...$arguments): self
    {
        if ($responsive) {
            $this->builder->createWrapper('div', ['class' => 'table-responsive']);
        }
        $this->builder->createScope('table', $arguments);
        $this->builder->prependClass($style ? "table table-$style" : 'table');
        return $this;
    }
}
