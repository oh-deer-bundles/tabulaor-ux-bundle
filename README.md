# ODB Tabulaltor UX Bundle

This Bundle helps to quickly implement [Tabulator](https://github.com/olifolkerd/tabulator) library in Symfony application. This bundle is a Symfony UX bundle. You can find more informations about [the Symfony UX initiative](https://ux.symfony.com/).

You can learn, show demo and more on [official Tabulator website](https://tabulator.info/examples/6.3)

## Installation

> /!\ caution
> Before you start, make sure you have `StimulusBundle configured in your app`.

Install the bundle using Composer and Symfony Flex:

```shell
composer require oh-deer-bundles/tabulator-ux-bundle
```

If you're using WebpackEncore, install your assets and restart Encore (not
needed if you're using AssetMapper):

```shell
# with npm
npm install --force
npm run watch

# or use yarn
yarn install --force
yarn watch
```

## Usage

To use Tabulator Ux Bundle, inject the ``TabulatorBuilderInterface`` service
and create Tabuylator in your app.

```php
 // ...
    use Odb\TabulatorUxBundle\Builder\TabulatorBuilderInterface;
    use Odb\TabulatorUxBundle\Model\Tabulator;

    class HomeController extends AbstractController
    {
        #[Route('/', name: 'app_homepage')]
        public function index(TabulatorBuilderInterface $tabulatorBuilder): Response
        {
            /** @var Tabulator $tabulator */
            $tabulator = $tabulatorBuilder->createTabulator();
            $tabulator->setAttributes([ 'style' => "height:500px"]);
            $tabulator->setOptions([
                "height" => "500px",
                'layout'=> 'fitColumns',
                "columns"=> [
                    ['title'=> 'Name', 'field'=>'name'],
                    ['title'=> 'Progress', 'field'=>'progress', 'hozAlign' => 'right', 'sorter' => 'number'],
                    ['title'=> 'Gender', 'field'=>'gender'],
                    ['title'=> 'Rating', 'field'=>'rating', 'hozAlign' => 'center'],
                    ['title'=> 'Favourite Color', 'field'=>'col'],
                    ['title'=> 'Date Of Birth', 'field'=>'dob', 'hozAlign' => 'center', 'sorter' => 'date'],
                    ['title'=> 'Driver', 'field'=>'car', 'hozAlign' => 'center'],
                    ['title'=> 'Favourite Color', 'field'=>'col']
                ],
            ]);
            
            $data =  [
                ['id' => 1, 'name' =>"Oli Bob", 'progress' =>12, 'location' =>"United Kingdom", 'gender' =>"male", 'rating' =>1, 'col' =>"red", 'dob' =>"14/04/1984", 'car' =>1, 'lucky_no' =>5, 'lorem' =>"Lorem ipsum dolor sit amet, elit consectetur adipisicing "],
                ['id' => 2, 'name' =>"Mary May", 'progress' =>1, 'location' =>"Germany", 'gender' =>"female", 'rating' =>2, 'col' =>"blue", 'dob' =>"14/05/1982", 'car' =>true, 'lucky_no' =>10, 'lorem' =>"Lorem ipsum dolor sit amet, elit consectetur adipisicing "],
                ['id' => 3, 'name' =>"Christine Lobowski", 'progress' =>42, 'location' =>"France", 'gender' =>"female", 'rating' =>0, 'col' =>"green", 'dob' =>"22/05/1982", 'car' =>"true", 'lucky_no' =>12, 'lorem' =>"Lorem ipsum dolor sit amet, elit consectetur adipisicing "],
                ['id' => 4, 'name' =>"Brendon Philips", 'progress' =>100, 'location' =>"USA", 'gender' =>"male", 'rating' =>1, 'col' =>"orange", 'dob' =>"01/08/1980", 'car' =>false, 'lucky_no' =>18, 'lorem' =>"Lorem ipsum dolor sit amet, elit consectetur adipisicing "],
                ['id' => 5, 'name' =>"Margret Marmajuke", 'progress' =>16, 'location' =>"Canada", 'gender' =>"female", 'rating' =>5, 'col' =>"yellow", 'dob' =>"31/01/1999", 'car' =>false, 'lucky_no' =>33, 'lorem' =>"Lorem ipsum dolor sit amet, elit consectetur adipisicing "],
                ['id' => 6, 'name' =>"Frank Harbours", 'progress' =>38, 'location' =>"Russia", 'gender' =>"male", 'rating' =>4, 'col' =>"red", 'dob' =>"12/05/1966", 'car' =>1, 'lucky_no' =>2, 'lorem' =>"Lorem ipsum dolor sit amet, elit consectetur adipisicing "],
                ['id' => 7, 'name' =>"Jamie Newhart", 'progress' =>23, 'location' =>"India", 'gender' =>"male", 'rating' =>3, 'col' =>"green", 'dob' =>"14/05/1985", 'car' =>true, 'lucky_no' =>63, 'lorem' =>"Lorem ipsum dolor sit amet, elit consectetur adipisicing "],
                ['id' => 8, 'name' =>"Gemma Jane", 'progress' =>60, 'location' =>"China", 'gender' =>"female", 'rating' =>0, 'col' =>"red", 'dob' =>"22/05/1982", 'car' =>"true", 'lucky_no' =>72, 'lorem' =>"Lorem ipsum dolor sit amet, elit consectetur adipisicing "],
                ['id' => 9, 'name' =>"Emily Sykes", 'progress' =>42, 'location' =>"South Korea", 'gender' =>"female", 'rating' =>1, 'col' =>"maroon", 'dob' =>"11/11/1970", 'car' =>false, 'lucky_no' =>44, 'lorem' =>"Lorem ipsum dolor sit amet, elit consectetur adipisicing "],
                ['id' => 10, 'name' =>"James Newman", 'progress'=>73, 'location' =>"Japan", 'gender' =>"male", 'rating' =>5, 'col' =>"red", 'dob' =>"22/03/1998", 'car' =>false, 'lucky_no' =>9, 'lorem' =>"Lorem ipsum dolor sit amet, elit consectetur adipisicing "],
            ];
    
            $tabulator->setData($data);
            return $this->render('path-to/tabulator.html.twig',['tabulator' => $tabulator]);
        }
    }
```
You can set each tabulator attributes separately.

```php
 // ...
     $tabulator->setAttributes([ 'style' => "height:500px"]);
```

Once created in PHP, the data grid can be displayed using Twig:

```html
   {{ {{ render_tabulator(tabulator) }}) }}

    {# You can pass HTML attributes as a second argument to add them on the <div> tag if you need it #}
    {{ {{ render_tabulator(tabulator, {'id': 'my-data-grid'}) }}
```

# Extends the Stimulus controller

If you need you can extend the bundle Stimulus controller, to add your javascript.

```javascript
// mydatagrid_controller.js

import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    connect() {
        this.element.addEventListener('tabulator:init', this.gridInit);
        this.element.addEventListener('tabulator:loaded', this.gridStarted);
    }

    disconnect() {
        // You should always remove listeners when the controller is disconnected to avoid side effects
        this.element.addEventListener('tabulator:init', this.agGridIniti);
        this.element.addEventListener('tabulator:loaded', this.gridStarted);
    }

    gridInit(event) {
        // The Tabulator is not yet created
        // You can access the gridOptions that will be passed to "tableBuilt" function
        console.log(event.detail.tabulatorOptions);
        
        // e.g. you want to add a editing option like this.
        event.detail.tabulatorOptions.editTriggerEvent = "dblclick"
    }

    gridStarted(event) {
        // The Tabulator was just created and You can access the Tabulor instance using the event details
        console.log(event.detail.tabulator);

        // For instance you can listen to additional events see https://www.ag-grid.com/javascript-data-grid/grid-events/
        event.detail.tabulator.on("cellEdited", function(cell){
            //cell - cell component
        });
        event.detail.tabulator.on("cellEditCancelled", function(cell){
            //cell - cell component
        });
    }
}
```

Then in your render call, add your controller as an HTML attribute:
- in twig
```html
    {{ render_ag_grid(agGrid, {'data-controller': 'mydatagrid'}) }}
```
- or in PHP
```php
    $agGrid->setAttributes([ 'data-controller' => 'mydatagrid']);
```

## TODO

Features need to be implemented
- tests
- language selection

## Special thanks

The Symfony UX Bundle is largely inspired by the superb [Symfony UX chart.js](https://symfony.com/bundles/ux-chartjs/current/index.html) Bundle.
Thanks to [Fabien Potencier](https://github.com/fabpot) to create the best PHP framework