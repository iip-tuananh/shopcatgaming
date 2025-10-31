@include('admin.products.ProductGallery')
@include('admin.products.ProductAttribute')
@include('admin.products.ProductVideo')
@include('admin.products.ProductType')
@include('admin.products.Attri')

<script>
    class Product extends BaseClass {
        no_set = [];
        all_categories = @json(\App\Model\Admin\Category::getForSelect());
        all_attributes = @json(\App\Model\Admin\Attribute::getForSelect());

        before(form) {
            this.image = {};
            this.status = 1;

            this._attrs = [];
        }

        after(form) {
            this.types = form.types && form.types.length
                ? form.types
                : [
                    new ProductType({ title: null}),
                ];
        }

        get types() {
            return this._types || [];
        }

        set types(value) {
            this._types = (value || []).map(val => new ProductType(val, this));
        }

        addType(result) {
            if (!this._types) this._types = [];
            let new_result = new ProductType(result, this);
            this._types.push(new_result);
            return new_result;
        }

        removeType(index) {
            this._types.splice(index, 1);
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

        get image() {
            return this._image;
        }

        set image(value) {
            this._image = new Image(value, this);
        }

        clearImage() {
            if (this.image) this.image.clear();
        }

        get galleries() {
            return this._galleries || [];
        }

        set galleries(value) {
            this._galleries = (value || []).map(val => new ProductGallery(val, this));
        }

        addGallery(gallery) {
            if (!this._galleries) this._galleries = [];
            let new_gallery = new ProductGallery(gallery, this);
            this._galleries.push(new_gallery);
            return new_gallery;
        }

        removeGallery(index) {
            this._galleries.splice(index, 1);
        }

        // attribute
        set attrs(value) {
            this._attrs = (value || []).map(val => new Attri(val, this))
        }

        get attrs() {
            return this._attrs || []
        }

        addAttributes(value) {
            const exists = this._attrs.some(attrWrapper =>
                attrWrapper.id === value.id
            );
            if (exists) {
                toastr.warning('Thuộc tính này đã được thêm');
                return;
            }

            this._attrs.push(new Attri(value, this));
        }

        removeAttributes(index) {
            this._attrs.splice(index, 1)
        }
        // end attribute

        get submit_data() {
            let data = {
                cate_id: this.cate_id,
                name: this.name,
                base_price: this._base_price,
                price: this._price,
                short_des: this.short_des,
                intro: this.intro,
                body: this.body,
                hdcd: this.hdcd,
                status: this.status,
                state: this.state,
                types: this.types.map(val => val.submit_data),
                attrs: this._attrs.map(val => val.submit_data),

            }

            data = jsonToFormData(data);
            let image = this.image.submit_data;
            if (image) data.append('image', image);

            this.galleries.forEach((g, i) => {
                if (g.id) data.append(`galleries[${i}][id]`, g.id);
                let gallery = g.image.submit_data;
                if (gallery) data.append(`galleries[${i}][image]`, gallery);
                else data.append(`galleries[${i}][image_obj]`, g.id);
            })

            return data;
        }
    }
</script>
