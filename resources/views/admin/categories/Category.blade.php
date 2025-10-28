<script>
    class Category extends BaseClass {
        no_set = [];
        all_categories = @json(\App\Model\Admin\Category::getForSelect(true));

        before(form) {
            this.image = {};
            this.banner = {};
            this.show_home_page = 1;
        }

        after(form) {
            this.custom_slug = this.custom_slug ?? this.slug;
        }


        get parent_id() {
            return this._parent_id;
        }

        set parent_id(value) {
            this._parent_id = Number(value);
        }
// Ảnh đại diện
        get image() {
            return this._image;
        }

        set image(value) {
            this._image = new Image(value, this);
        }

		clearImage() {
			if (this.image) this.image.clear();
		}
// Ảnh banner
        get banner() {
            return this._banner;
        }

        set banner(value) {
            this._banner = new Image(value, this);
        }

		clearBanner() {
			if (this.banner) this.banner.clear();
		}

        get submit_data() {
            let data = {
                parent_id: this._parent_id,
                code: this.code,
                subtitle: this.subtitle,
                custom_slug: this.custom_slug,
                name: this.name,
                intro: this.intro,
                short_des: this.short_des,
                icon: this.icon,
                show_home_page: this.show_home_page,
                seo_title: this.seo_title,
                seo_description: this.seo_description,
            }
            data = jsonToFormData(data);
            let image = this.image.submit_data;
            let banner = this.banner.submit_data;
            if (image) data.append('image', image);
            if (banner) data.append('banner', banner);

            return data;
        }
    }
</script>
