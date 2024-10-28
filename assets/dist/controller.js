import { Controller } from '@hotwired/stimulus';
import {TabulatorFull as Tabulator} from 'tabulator-tables';


class default_tabulator extends Controller {
    constructor() {
        super(...arguments);
        this.tabulatorOptions = {};
        this.tabulator = null;
    }


    connect() {
        const _self = this;
        if (!this.optionsValue) {
            throw new Error('Invalid element, no options set');
        }

        if (this.element instanceof HTMLDivElement) {
            _self.tabulatorOptions = _self.optionsValue;
        }

        this.dispatchEvent('init', {
            options: _self.tabulatorOptions,
        });

        _self.tabulator = new Tabulator(_self.element, _self.tabulatorOptions);

        _self.tabulator.on("tableBuilt", () => {
            _self.dispatchEvent('loaded', {tabulator: _self.tabulator});
        });

    }

    dispatchEvent(name, payload) {
        this.dispatch(name, { detail: payload, prefix: 'tabulator' });
    }
}

default_tabulator.values = {
    options: Object,
};

export { default_tabulator as default };