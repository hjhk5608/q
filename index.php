<!DOCTYPE html>
<html lang="cn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QQ绑定查询</title>

    <!-- 引入Bootstrap的CSS文件 -->
    <link rel="stylesheet" href="https://cdn.bootcdn.net/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">

    <!-- 引入Font Awesome的CSS文件 -->
    <link rel="stylesheet" href="https://cdn.bootcdn.net/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        .text-center-vh {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .loader {
            font-size: 4rem;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header text-center">
                <h5 class="m-0">QQ绑定查询</h5>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="qqInput">请输入QQ号码：</label>
                    <input type="text" id="qqInput" class="form-control">
                </div>
                <div class="text-center text-center-vh">
                    <i class="fas fa-spinner fa-spin loader" id="loadingSpinner"></i>
                </div>
                <button id="searchBtn" class="btn btn-primary btn-block w-100 mt-4">查询</button>

                <div id="result" class="mt-4"></div>
            </div>
        </div>
    </div>

    <!-- 引入Bootstrap的JS文件 -->
    <script src="https://cdn.bootcdn.net/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        // 获取查询按钮和结果容器元素
        const searchBtn = document.getElementById('searchBtn');
        const resultContainer = document.getElementById('result');
        const qqInput = document.getElementById('qqInput');
        const loadingSpinner = document.getElementById('loadingSpinner');

        // 设置加载状态
        let loading = false;

        // 页面加载完成后隐藏加载圆圈
        window.addEventListener('load', function () {
            loadingSpinner.style.display = 'none';
        });

        searchBtn.addEventListener('click', function () {
            // 如果在加载中，直接返回
            if (loading) {
                return;
            }

            // 获取输入的QQ号码
            const qq = qqInput.value;

            if (qq === '') {
                // 处理输入为空的情况
                resultContainer.innerHTML = '<p class="text-danger">输入不能为空</p>';
                return;
            }

            // 显示加载圆圈和禁用输入和按钮
            loadingSpinner.style.display = 'inline-block';
            qqInput.disabled = true;
            searchBtn.disabled = true;

            // 设置加载状态为 true
            loading = true;

            // 发送API请求
            const apiUrl = `https://zy.xywlapi.cc/qqapi?qq=${qq}`;
            fetch(apiUrl)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 200) {
                        // 渲染查询结果
                        resultContainer.innerHTML = `
                            <p><strong>QQ号码:</strong> ${data.qq}</p>
                            <p><strong>手机号码:</strong> ${data.phone}</p>
                            <p><strong>手机号码归属地:</strong> ${data.phonediqu}</p>
                        `;
                    } else {
                        // 处理没有找到的情况
                        resultContainer.innerHTML = `<p class="text-danger">${data.message}</p>`;
                    }

                    // 隐藏加载圆圈和启用输入和按钮
                    loadingSpinner.style.display = 'none';
                    qqInput.disabled = false;
                    searchBtn.disabled = false;
                    // 设置加载状态为 false
                    loading = false;
                },1000)
                .catch(error => {
                    // 处理其他错误
                    resultContainer.innerHTML = `<p class="text-danger">查询出错: ${error}</p>`;

                    // 隐藏加载圆圈和启用输入和按钮
                    loadingSpinner.style.display = 'none';
                    qqInput.disabled = false;
                    searchBtn.disabled = false;
                    // 设置加载状态为 false
                    loading = false;
                },1000);
        });
    </script>
</body>

</html>