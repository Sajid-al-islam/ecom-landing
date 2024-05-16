import StoreModule from "./schema/StoreModule";

let test_module = new StoreModule('order','order','Order');
const {store_prefix, api_prefix, route_prefix} = test_module;

// state list
const state = {
    ...test_module.states(),
    orderByAsc: false,
};

// get state
const getters = {
    ...test_module.getters(),
};

// actions

const actions = {
    ...test_module.actions(),

    [`fetch_${store_prefix}`]: async function ({ state, commit }, { id }) {
        let url = `/${api_prefix}/${id}`;
        await axios.get(url).then((res) => {
            this.commit(`set_${store_prefix}`, res.data);

            var img_string="";
            if(res.data.related_images) {
                for (let index = 0; index < res.data.related_images.length; index++) {
                    let el = res.data.related_images[index];
                    img_string +=`<img src="/${el.image}"/>`
                }
                setTimeout(() => {

                    document.querySelector('.file_preview')&&
                    (document.querySelector('.file_preview').innerHTML = img_string)
                }, 1000);
            }

        });
    },

    [`store_${store_prefix}`]: function({state, getters, commit}){
        const {form_values, form_inputs, form_data} = window.get_form_data(`.create_form`);
        // console.log(form_data, form_inputs, form_values);
        const {get_category_selected: category} = getters;

        category.forEach((i)=> {
            form_data.append('selected_categories[]',i.id);
        });
        // console.log(form_data);
        axios.post(`/${api_prefix}/store`,form_data)
            .then(res=>{
                window.s_alert(`new ${store_prefix} has been created`);
                $(`${store_prefix}_create_form input`).val('');
                commit(`set_clear_selected_${store_prefix}s`,false);
                management_router.push({name:`All${route_prefix}`})
            })
            .catch(error=>{

            })
    },


    [`update_${store_prefix}`]: function ({ state, getters, commit }, event) {
        const {form_values, form_inputs, form_data} = window.get_form_data(`.update_form`);
        const {get_category_selected: category} = getters;

        category.forEach((i)=> {
            form_data.append('selected_categories[]',i.id);
        });
        form_data.append("id", state[store_prefix].id);
        axios.post(`/${api_prefix}/update`, form_data).then((res) => {
            /** reset loaded user_role after data update */
            // this.commit(`set_${store_prefix}`, null);
            window.s_alert("data updated");
        });
    },

    [`set_${store_prefix}_status_update`]: function ({ state, getters, commit }, event) {
        const {form_values, form_inputs, form_data} = window.get_form_data(`.status_change_form`);

        form_data.append("id", state[store_prefix].id);

        axios.post(`/${api_prefix}/status_update`, form_data).then((res) => {
            console.log("login store data", state[store_prefix].id);
            let order_id = state[store_prefix].id;
            this.dispatch(`fetch_${store_prefix}`, { id: order_id });
            window.s_alert("data updated");
        });
    },

    [`print_${store_prefix}_details`]: function ({ state, getters, commit }, event) {
        window.print();
    },

    [`email_${store_prefix}_invoice`]: function ({ state, getters, commit }, event) {

    },

    [`export_${store_prefix}_all`]: async function ({ state, commit }) {
        let cconfirm = await window.s_confirm("export all");
        if (cconfirm) {
          let col = ['Customer Name', 'Mobile Number', 'Address'];
          let other_cols = Object.keys(state[`${store_prefix}s`].data[0]);
          other_cols = other_cols.filter(
            (key) =>
              !['products', 'order_payments', 'order_address'].includes(key)
          );
          col = col.concat(other_cols);

          var export_csv = new window.CsvBuilder(
            `${store_prefix}_list.csv`
          ).setColumns(col);
          window.start_loader();
          let last_page = state[`${store_prefix}s`].last_page;
          for (let index = 1; index <= last_page; index++) {
            state.page = index;
            state.paginate = 10;
            await this.dispatch(`fetch_${store_prefix}s`);
            let values = state[`${store_prefix}s`].data.map((i) => {
              let row = {
                'Customer Name': i.order_address?.first_name || '',
                'Mobile Number': i.order_address?.mobile_number || '',
                'Address': i.order_address?.address || '',
              };
              other_cols.forEach((key) => {
                row[key] = i[key];
              });
              return Object.values(row);
            });
            export_csv.addRows(values);
            let progress = Math.round((100 * index) / last_page);
            window.update_loader(progress);
          }
          await export_csv.exportFile();
          window.remove_loader();
        }
    },

    [`export_selected_${store_prefix}_csv`]: function ({ state }) {
        let col = ['Customer Name', 'Mobile Number', 'Address'];
        let other_cols = Object.keys(state[`${store_prefix}_selected`][0]);
        other_cols = other_cols.filter(
            (key) => !['products', 'order_payments', 'order_address'].includes(key)
        );
        col = col.concat(other_cols);

        let values = state[`${store_prefix}_selected`].map((i) => {
            let row = {
            'Customer Name': i.order_address?.first_name || '',
            'Mobile Number': i.order_address?.mobile_number || '',
            'Address': i.order_address?.address || '',
            };
            other_cols.forEach((key) => {
                row[key] = i[key];
            });
            return Object.values(row);
        });

    new window.CsvBuilder(`${store_prefix}_list.csv`)
        .setColumns(col)
        .addRows(values)
        .exportFile();
    },


}

// mutators
const mutations = {
    ...test_module.mutations(),

};


export default {
    state,
    getters,
    actions,
    mutations,
};
