<?php

namespace Odb\TabulatorUxBundle\Twig;



use Odb\TabulatorUxBundle\Model\Tabulator;
use Symfony\UX\StimulusBundle\Helper\StimulusHelper;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class TabulatorTwigExtension extends AbstractExtension
{
    public function __construct(StimulusHelper|StimulusTwigExtension $stimulus)
    {
        if ($stimulus instanceof StimulusTwigExtension) {
            $stimulus = new StimulusHelper(null);
        }

        $this->stimulus = $stimulus;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('render_tabulator', [$this, 'renderTabulator'], ['is_safe' => ['html']]),
        ];
    }

    public function renderTabulator(Tabulator $tabulator, array $attributes = []): string
    {
        $tabulator->setAttributes(array_merge($tabulator->getAttributes(),$attributes));
        $controllers = [];
        if ($tabulator->getDataController()) {
            $controllers[$tabulator->getDataController()] = [];
        }
        $controllers['@oh-deer-bundles/tabulator-ux-bundle/tabulator'] = ['options' => $tabulator->createView()];

        $stimulusAttributes = $this->stimulus->createStimulusAttributes();
        foreach ($controllers as $name => $controllerValues) {
            $stimulusAttributes->addController($name, $controllerValues);
        }

        foreach ($tabulator->getAttributes() as $name => $value) {
            if ('data-controller' === $name) {
                continue;
            }

            if (true === $value) {
                $stimulusAttributes->addAttribute($name, $name);
            } elseif (false !== $value) {
                $stimulusAttributes->addAttribute($name, $value);
            }
        }

        return \sprintf('<div %s></div>', $stimulusAttributes);
    }
}