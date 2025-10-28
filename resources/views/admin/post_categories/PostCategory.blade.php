<script>
    class PostCategory extends BaseClass {
        no_set = [];
        all_categories = @json(\App\Model\Admin\PostCategory::getForSelect());

        before(form) {
            this.image = {};
        }

        after(form) {
            if(this.categories) {
                this.all_categories = this.categories;
            }
        }


        get parent_id() {
            return this._parent_id;
        }

        set parent_id(value) {
            this._parent_id = Number(value);
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

        get submit_data() {
            let data = {
                name: this.name,
                intro: this.intro,
            }
            data = jsonToFormData(data);
            let image = this.image.submit_data;
            if (image) data.append('image', image);

            return data;
        }
    }
</script>
