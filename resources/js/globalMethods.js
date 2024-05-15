// globalMethods.js

import axios from 'axios';

const fetchUserData = function (userId, url) {
    if (window.location.pathname.startsWith('/procurement/rfq')) {
        return axios.get(`../../api/fetchUser/${userId}`)
            .then((response) => {
                return response.data;
            }).catch(error => {
                console.error('Error fetching user data:', error);
                return null; // or handle the error appropriately
            });
    } else {
        return axios.get(`${url}/${userId}`)
            .then((response) => {
                return response.data;
            }).catch(error => {
                console.error('Error fetching user data:', error);
                return null; // or handle the error appropriately
            });
    }
};



const countTotalItem = function (cur_year) {
    return axios.get(`../api/countTotalItem/${cur_year}`)
        .then((response) => {
            return response.data[0].item;
        }).catch(error => {
            console.error('Error totalItem  data:', error);
            return null; // or handle the error appropriately
        });
};


const countICTRequest = function (url, cur_year) {
    return axios.get(`${url}/${cur_year}`)
        .then((response) => {
            return response.data[0].ict

        }).catch(error => {
            console.error('Error totalItem  data:', error);
            return null; // or handle the error appropriately
        });
};

const count = function (url, status) {
    return axios.get(`${url}/${status}`)
        .then((response) => {
            return response.data[0]

        }).catch(error => {
            console.error('Error totalItem  data:', error);
            return null; // or handle the error appropriately
        });
};

const countCancelledPR = function (userId) {
    if (window.location.pathname.startsWith('/procurement/rfq')) {
        return axios.get(`../../api/countCancelledPR/${userId}`)
            .then((response) => {
                return response.data[0].cancelled_pr;
            }).catch(error => {
                console.error('Error fetching cancel purchase data:', error);
                return null; // or handle the error appropriately
            });
    } else {
        return axios.get(`../api/countCancelledPR/${userId}`)
            .then((response) => {
                return response.data[0].cancelled_pr;
            }).catch(error => {
                console.error('Error fetching cancel purchase data:', error);
                return null; // or handle the error appropriately
            });
    }

}

const countUserTotalPR = function (userId) {
    if (window.location.pathname.startsWith('/procurement/rfq')) {
        return axios.get(`../../api/countUserTotalPR/${userId}`)
            .then((response) => {
                return response.data[0].total_pr;
            }).catch(error => {
                console.error('Error fetching total purchase data:', error);
                return null; // or handle the error appropriately
            });
    } else {
        return axios.get(`../api/countUserTotalPR/${userId}`)
            .then((response) => {
                return response.data[0].total_pr;
            }).catch(error => {
                console.error('Error fetching total purchase data:', error);
                return null; // or handle the error appropriately
            });
    }

}

const fetchAppItem = function () {
    return axios
        .get('../api/appitems')
        .then(response => {
            return response.data;
        })
        .catch(error => {
            console.log(error.response);
            return null
        });
}
const fetchICTData = function () {
    return axios
        .get('../api/ict_data')
        .then(response => {
            return response.data;
        })
        .catch(error => {
            console.log(error.response);
            return null
        });
}

const fetchCartItemInfo = function (itemSelected) {
    return axios.get(`../api/fetchCartItemInfo/${itemSelected}`)
        .then((response) => {

            return response.data[0];
        }).catch(error => {
            console.log(error.response);
            return null
        });
}
const formatTotalAmount = function (amount) {
    // Parse the string to float, fix to 2 decimal places, add commas for thousand separators, and return
    return parseFloat(amount).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}


const updatePurchaseRequestStatus = function (pr_id, STATUS_SUBMITTED_TO_GSS) {
    return axios.post('../../api/post_update_status', {
        pr_id: pr_id,
        status: STATUS_SUBMITTED_TO_GSS
    })
        .then(response => {
            // Handle response if needed
            console.log(response.data);
            return response.data;
        })
        .catch(error => {
            // Handle error if needed
            console.error(error);
            return null;
        });
};

const formatDecimal = function (value) {
    return value.toFixed(2)

}

const formatDate= function (date) {
    if (!date || date === '0000-00-00') {
        return null; // Return null if the date is null or '0000-00-00'
    } else {
        const formattedDate = new Date(date).toLocaleString('en-US', {
            year: 'numeric',
            month: 'short',
            day: 'numeric',

        });
        return formattedDate;
    }
}






export {
    fetchUserData,
    countTotalItem,
    countICTRequest,
    count,
    countCancelledPR,
    countUserTotalPR,
    fetchAppItem,
    fetchCartItemInfo,
    formatTotalAmount,
    updatePurchaseRequestStatus,
    fetchICTData,
    formatDecimal,
    formatDate
};
