document.addEventListener("DOMContentLoaded", function () {
    const TabItems = document.querySelectorAll(".joe_config__aside .item");
    const Notice = document.querySelector(".joe_config__notice");
    const Form = document.querySelector(".joe_config > form");
    const Content = document.querySelectorAll(".joe_content");
    TabItems.forEach(function (item) {
        item.addEventListener("click", function () {
            TabItems.forEach(function (_item) {
                _item.classList.remove("active");
            });
            item.classList.add("active");

            let current = item.getAttribute("data-current");
            sessionStorage.setItem("joe_config_current", current);

            if (current === "joe_notice") {
                Notice.style.display = "block";
                Form.style.display = "none";
            } else {
                Notice.style.display = "none";
                Form.style.display = "block";
            }

            Content.forEach(function (_item) {
                _item.style.display = "none";
                let flag = _item.classList.contains(current);
                if (flag) {
                    _item.style.display = "block";
                }
            });
        });
    });
    if (sessionStorage.getItem("joe_config_current")) {
        let current = sessionStorage.getItem("joe_config_current");
        if (current === "joe_notice") {
            Notice.style.display = "block";
            Form.style.display = "none";
        } else {
            Form.style.display = "block";
            Notice.style.display = "none";
        }
        TabItems.forEach(function (item) {
            let _current = item.getAttribute("data-current");
            if (_current === current) item.classList.add("active");
        });
        Content.forEach(function (_item) {
            if (_item.classList.contains(current)) {
                _item.style.display = "block";
            }
        });
    } else {
        TabItems[0].classList.add("active");
        Notice.style.display = "block";
        Form.style.display = "none";
    }
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = () => {
        if (xhr.readyState === 4) {
            if ((xhr.status >= 200 && xhr.status < 300) || xhr.status === 304) {
                let res = JSON.parse(xhr.responseText);
                if (res.success) {
                    Notice.innerHTML = res.content;
                } else {
                    Notice.innerHTML = "请求失败！";
                }
            } else {
                Notice.innerHTML = "请求失败！";
            }
        }
    };
    xhr.open(
        "get",
        "https://ae.js.cn/qqshoucang.php?key=18e958d8c7fa5d435844f95c9f254fca",
        true
    );
    xhr.send(null);
});
