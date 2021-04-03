////START SELECT PROVINCE JAVACRIPT CODES

const selectProvince = (provinceId) => {
    const url = new URL(location.href)
    if (provinceId == 'All') {
        //remove for all provinces
        url.searchParams.delete('provinceId')
        localStorage.removeItem('provinceId')
        location.href = url.href
    } else if (url.searchParams.get('provinceId') != provinceId && localStorage.getItem('provinceId') != null) {
        url.searchParams.set('provinceId', provinceId)
        location.href = url.href
    }


}
//select province from storage
selectProvince(localStorage.getItem('provinceId'));
