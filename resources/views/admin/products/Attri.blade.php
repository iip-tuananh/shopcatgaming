@include('admin.products.AttributeValue')

<script>
    class Attri extends BaseChildClass {

        before(form) {
            this._values = [];

        }

        set values(value) {
            this._values = (value || []).map(val => new AttributeValue(val, this))
        }

        get values () {
            return this._values || []
        }

        addValues(value) {
            this._values.push(new AttributeValue(value, this));
        }

        removeValues(index) {
            this._values.splice(index, 1)
        }

        get submit_data() {
            return {
                id: this.id,
                name: this.name,
                values: this.values.map(val => val.submit_data)

            }
        }
    }
</script>
