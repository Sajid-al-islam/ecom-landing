// state list
const state = {
    company_info: {
        'company_name': "Organic Ghor",
        'address': [
            {
                "building": "",
                "lane": "",
                "shop": "",
                "area": "Uttara",
                "division": "Dhaka, Bangladesh",
            }
        ],
        'mobile_no': [
            '01849-990617'
        ],
        'email': 'organicghorbd@gmail.com'
    },
};

// get state
const getters = {
    get_company_info: state => state.company_info,
};

// actions

const actions = {

}

// mutators
const mutations = {

};


export default {
    state,
    getters,
    actions,
    mutations,
};
