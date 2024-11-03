function confirmDelete(title, text) {
    return Swal.fire({
        title: title,
        text: text,
        icon: "warning",
        iconColor: "#e3342f",
        background: "#191c23",
        color: "#fff",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "gray",
        cancelButtonText: "الغاء",
        confirmButtonText: "حذف"
    });
}
