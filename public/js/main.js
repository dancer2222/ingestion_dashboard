function redirect(link) {
    console.log(link);
    location.replace(location.origin + location.pathname + link);
}