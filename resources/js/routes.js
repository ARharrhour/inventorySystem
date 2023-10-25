let home = require("./components/home.vue").default;
// auth routes
let login = require("./components/auth/login.vue").default;
let register = require("./components/auth/register.vue").default;
let forget = require("./components/auth/forget.vue").default;
let logout = require("./components/auth/logout.vue").default;
// end auth routes

// employees routes

let storeEmployee = require("./components/employee/create.vue").default;
let employees = require("./components/employee/index.vue").default;
let editEmployee = require("./components/employee/edit.vue").default;
// end employees routes
let storeCategory = require("./components/category/create.vue").default;
let editCategory = require("./components/category/edit.vue").default;
let categories = require("./components/category/index.vue").default;

let storeSupplier = require("./components/supplier/create.vue").default;
let editSupplier = require("./components/supplier/edit.vue").default;
let suppliers = require("./components/supplier/index.vue").default;



let storeProduct = require("./components/product/create.vue").default;
let editProduct = require("./components/product/edit.vue").default;
let products = require("./components/product/index.vue").default;

let storeCustomer = require("./components/customer/create.vue").default;
let editCustomer = require("./components/customer/edit.vue").default;
let customers = require("./components/customer/index.vue").default;


let storeExpense = require("./components/expense/create.vue").default;
let editExpense = require("./components/expense/edit.vue").default;
let expenses = require("./components/expense/index.vue").default;


let salary = require("./components/salary/all_employee.vue").default;
let pay_salary = require("./components/salary/create.vue").default;
let salaries = require("./components/salary/index.vue").default;
let viewSalary = require("./components/salary/view.vue").default;
let editSalary = require("./components/salary/edit.vue").default;

export const routes = [
    { path: "/", component: login, name: "/" },
    { path: "/register", component: register, name: "register" },
    { path: "/forget", component: forget, name: "forget" },
    { path: "/home", component: home, name: "home" },
    { path: "/logout", component: logout, name: "logout" },
    // employees routes
    { path: "/employee", component: employees, name: "employees" },
    {
        path: "/employee/store",
        component: storeEmployee,
        name: "storeEmployee",
    },
    {
        path: "/employee/edit/:id",
        component: editEmployee,
        name: "editEmployee",
    },
    // end employees routes

    // categories routes
    {
        path: "/category/store",
        component: storeCategory,
        name: "storeCategory",
    },
    {
        path: "/category/edit/:id",
        component: editCategory,
        name: "editCategory",
    },
    { path: "/category", component: categories, name: "categories" },
    // end categories routes

    // suppliers routes
    {
        path: "/supplier/store",
        component: storeSupplier,
        name: "storeSupplier",
    },
    {
        path: "/supplier/edit/:id",
        component: editSupplier,
        name: "editSupplier",
    },
    { path: "/supplier", component: suppliers, name: "suppliers" },
    // end suppliers routes

    // products routes
    { path: "/product/store", component: storeProduct, name: "storeProduct" },
    { path: "/product/edit/:id", component: editProduct, name: "editProduct" },
    { path: "/product", component: products, name: "products" },
    // end products routes

    // customers routes
    {
        path: "/customer/store",
        component: storeCustomer,
        name: "storeCustomer",
    },
    {
        path: "/customer/edit/:id",
        component: editCustomer,
        name: "editCustomer",
    },
    { path: "/customer", component: customers, name: "customers" },
    // end customer routes
    // expenses routes
    {
        path: "/expense/store",
        component: storeExpense,
        name: "storeExpense",
    },
    {
        path: "/expense/edit/:id",
        component: editExpense,
        name: "editExpense",
    },
    { path: "/expense", component: expenses, name: "expenses" },
    // end expense routes

    // salaries routes

    {path:"/given-salary",component:salary,name:"given-salary"},
    {path:"/pay-salary/:id",component:pay_salary,name:"pay-salary"},
    {path:"/salary",component:allSalary,name:"salaries"},
    {path:"/view-salary/:id",component:viewSalary,name:"view-salary"},
    {path:"/edit-salary/:id",component:editSalary,name:"edit-salary"},
    //end salaries routes

];
