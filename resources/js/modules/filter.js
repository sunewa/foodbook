import moment from "moment";

Vue.filter("upperCase", function(text) {
    return text.toUpperCase();
});
Vue.filter("myDate", function(text) {
    return moment(text).format("MMMM Do YYYY, h:mm:ss a");
});
