@include('admin.configs.ConfigGallery')

<script>
    class Config extends BaseClass {
        no_set = [];
        before(form) {
            this.image = {};
        }
        after(form) {
        }
        get image() {
            return this._image;
        }
        set image(value) {
            this._image = new Image(value, this);
        }

        get image_back() {
            return this._image_back;
        }
        set image_back(value) {
            this._image_back = new Image(value, this);
        }

		clearImage() {
			if (this.image) this.image.clear();
			if (this.image_back) this.image_back.clear();
		}

        get favicon() {
            return this._favicon;
        }

        set favicon(value) {
            this._favicon= new Image(value, this);
        }

        clearFavicon() {
            if (this.favicon) this.favicon.clear();
        }

        get galleries() {
            return this._galleries || [];
        }

        set galleries(value) {
            this._galleries = (value || []).map(val => new ConfigGallery(val, this));
        }

        addGallery(gallery) {
            if (!this._galleries) this._galleries = [];
            let new_gallery = new ConfigGallery(gallery, this);
            this._galleries.push(new_gallery);
            return new_gallery;
        }

        removeGallery(index) {
            this._galleries.splice(index, 1);
        }

        get video() {
            return this._video;
        }

        set video(value) {
            this._video = new File(value, this, this.sce);
        }

        get submit_data() {
            let data = {
                web_title: this.web_title,
                web_des: this.web_des,
                web_des_eng: this.web_des_eng,
                short_name_company: this.short_name_company,
                email: this.email,
                twitter: this.twitter,
                instagram: this.instagram,
                youtube: this.youtube,
                facebook: this.facebook,
                hotline: this.hotline,
                address_company: this.address_company,
                address_company_eng: this.address_company_eng,
                address_center_insurance: this.address_center_insurance,
                zalo: this.zalo,
                location: this.location,
                google_map: this.google_map,
                click_call: this.click_call,
                facebook_chat: this.facebook_chat,
                zalo_chat: this.zalo_chat,
                phone_switchboard: this.phone_switchboard,
                introduction: this.introduction,
                introduction_eng: this.introduction_eng,
                tax_code: this.tax_code,
                youtube_iframe: this.youtube_iframe,
                hdmh: this.hdmh,
                facebook_mess: this.facebook_mess,
            }
            data = jsonToFormData(data);
            let image = this.image.submit_data;
            if (image) data.append('image', image);

            let image_back = this.image_back.submit_data;
            if (image_back) data.append('image_back', image_back);

            let favicon = this.favicon.submit_data;
            if (favicon) data.append('favicon', favicon);
            // let video = this.video.submit_data;
            // if (video) data.append('video', video);

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
