<script>
    class ProductType extends BaseChildClass {

        before(form) {
        }

        after(form) {

        }

        get base_price() {
            return this._base_price ? this._base_price.toLocaleString('en') : '';
        }

        set base_price(value) {
            value = parseNumberString(value);
            this._base_price = value;
        }

        get price() {
            return this._price ? this._price.toLocaleString('en') : '';
        }

        set price(value) {
            value = parseNumberString(value);
            this._price = value;
        }

        get submit_data() {
            let data =  {
                title: this.title ?? null,
                base_price: this._base_price,
                price: this._price,
            }

            return data;
        }


    }
</script>
