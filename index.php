<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>学生作业查询</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: #f5f5f5;
            color: #333;
            line-height: 1.6;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 16px;
        }
        
        header {
            background-color: #3498db;
            color: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
        }
        
        h1 {
            font-size: 20px;
            margin-bottom: 10px;
        }
        
        .subtitle {
            font-size: 14px;
            opacity: 0.9;
        }
        
        .login-form {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        
        .form-group {
            margin-bottom: 16px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            font-size: 14px;
        }
        
        input[type="text"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            background-color: #f9f9f9;
        }
        
        button {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 14px;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100%;
            margin-top: 8px;
        }
        
        button:hover {
            background-color: #2980b9;
        }
        
        .homework-list {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            display: none;
        }
        
        .homework-item {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 16px;
            transition: box-shadow 0.3s;
            background-color: #fff;
        }
        
        .homework-item:hover {
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        
        .homework-header {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }
        
        .subject-tag {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 16px;
            font-size: 14px;
            font-weight: bold;
            color: white;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }
        
        .subject-tag.chinese {
            background-color: #E74C3C;
        }
        
        .subject-tag.math {
            background-color: #3498DB;
        }
        
        .subject-tag.english {
            background-color: #F39C12;
        }
        
        .subject-tag.physics {
            background-color: #2980B9;
        }
        
        .subject-tag.chemistry {
            background-color: #9B59B6;
        }
        
        .subject-tag.biology {
            background-color: #27AE60;
        }
        
        .subject-tag.history {
            background-color: #E67E22;
        }
        
        .subject-tag.geography {
            background-color: #27AE60;
        }
        
        .subject-tag.politics {
            background-color: #1ABC9C;
        }
        
        .subject-tag.other {
            background-color: #95A5A6;
        }
        
        .homework-meta {
            font-size: 13px;
            color: #666;
            margin-top: 4px;
            width: 100%;
        }
        
        .due-date {
            margin-left: 0;
            margin-top: 4px;
            display: block;
        }
        
        .due-date.overdue {
            color: #e74c3c;
            font-weight: bold;
        }
        
        .homework-content {
            margin-top: 12px;
            line-height: 1.5;
            font-size: 15px;
            color: #333;
        }
        
        .error-message {
            color: #e74c3c;
            margin-top: 10px;
            font-size: 14px;
        }
        
        .back-button {
            background-color: #95a5a6;
            margin-top: 20px;
            padding: 12px;
        }
        
        .back-button:hover {
            background-color: #7f8c8d;
        }
        
        .school-info {
            margin-bottom: 20px;
            padding: 16px;
            background-color: #f9f9f9;
            border-radius: 6px;
            font-size: 14px;
            line-height: 1.5;
        }
        
        .school-info strong {
            color: #333;
        }
        
        /* 响应式设计优化 */
        @media (max-width: 768px) {
            .container {
                padding: 12px;
            }
            
            header {
                padding: 16px;
            }
            
            h1 {
                font-size: 18px;
            }
            
            .login-form, .homework-list {
                padding: 16px;
            }
            
            .homework-item {
                padding: 14px;
                margin-bottom: 14px;
            }
            
            .subject-tag {
                font-size: 13px;
                padding: 5px 10px;
            }
            
            .homework-content {
                font-size: 14px;
            }
            
            .school-info {
                font-size: 13px;
                padding: 14px;
            }
        }
        
        /* 小屏幕手机优化 */
        @media (max-width: 480px) {
            .container {
                padding: 8px;
            }
            
            header {
                padding: 12px;
            }
            
            h1 {
                font-size: 16px;
            }
            
            .login-form, .homework-list {
                padding: 12px;
            }
            
            .homework-item {
                padding: 12px;
                margin-bottom: 12px;
            }
            
            .subject-tag {
                font-size: 12px;
                padding: 4px 8px;
            }
            
            .homework-content {
                font-size: 13px;
                line-height: 1.4;
            }
            
            .school-info {
                font-size: 12px;
                padding: 12px;
            }
            
            button {
                padding: 12px;
                font-size: 14px;
            }
            
            input[type="text"] {
                padding: 10px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>学生作业查询系统</h1>
            <div class="subtitle">输入学校代码和班级代码查看作业</div>
        </header>
        
        <div class="login-form" id="loginForm">
            <h2>身份验证</h2>
            <div class="form-group">
                <label for="schoolCode">学校代码</label>
                <input type="text" id="schoolCode" placeholder="例如：school123">
            </div>
            <div class="form-group">
                <label for="classCode">班级代码</label>
                <input type="text" id="classCode" placeholder="例如：class01">
            </div>
            <button id="submitBtn">查询作业</button>
            <div class="error-message" id="errorMessage"></div>
        </div>
        
        <div class="homework-list" id="homeworkList">
            <div class="school-info" id="schoolInfo"></div>
            <div id="homeworkContent"></div>
            <button class="back-button" id="backBtn">返回</button>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loginForm = document.getElementById('loginForm');
            const homeworkList = document.getElementById('homeworkList');
            const submitBtn = document.getElementById('submitBtn');
            const backBtn = document.getElementById('backBtn');
            const errorMessage = document.getElementById('errorMessage');
            const schoolCodeInput = document.getElementById('schoolCode');
            const classCodeInput = document.getElementById('classCode');
            const schoolInfo = document.getElementById('schoolInfo');
            const homeworkContent = document.getElementById('homeworkContent');
            
            // 提交按钮点击事件
            submitBtn.addEventListener('click', function() {
                const schoolCode = schoolCodeInput.value.trim();
                const classCode = classCodeInput.value.trim();
                
                if (!schoolCode || !classCode) {
                    errorMessage.textContent = '请输入完整的学校代码和班级代码';
                    return;
                }
                
                // 发送请求获取作业数据
                fetch('homework-sync.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        action: 'student',
                        schoolCode: schoolCode,
                        classCode: classCode
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // 显示作业列表
                        loginForm.style.display = 'none';
                        homeworkList.style.display = 'block';
                        
                        // 更新学校信息
                        schoolInfo.innerHTML = `
                            <strong>学校：</strong>${schoolCode}<br>
                            <strong>班级：</strong>${classCode}<br>
                            <strong>最后更新：</strong>${new Date(data.lastUpdated * 1000).toLocaleString()}
                        `;
                        
                        // 渲染作业列表
                        renderHomeworkList(data.homeworkData);
                    } else {
                        errorMessage.textContent = data.message || '查询失败';
                    }
                })
                .catch(error => {
                    console.error('查询失败:', error);
                    errorMessage.textContent = '网络错误，请稍后重试';
                });
            });
            
            // 返回按钮点击事件
            backBtn.addEventListener('click', function() {
                homeworkList.style.display = 'none';
                loginForm.style.display = 'block';
                errorMessage.textContent = '';
            });
            
            // 渲染作业列表
            function renderHomeworkList(homeworkData) {
                if (!homeworkData || homeworkData.length === 0) {
                    homeworkContent.innerHTML = '<p style="text-align: center; color: #666; padding: 20px;">暂无作业</p>';
                    return;
                }
                
                // 按截止日期排序
                homeworkData.sort((a, b) => {
                    const dateA = a.dueDate ? new Date(a.dueDate) : new Date(0);
                    const dateB = b.dueDate ? new Date(b.dueDate) : new Date(0);
                    return dateA - dateB;
                });
                
                let html = '';
                const today = new Date();
                today.setHours(0, 0, 0, 0);
                
                homeworkData.forEach(homework => {
                    // 检查是否过期
                    let isOverdue = false;
                    let dueDateStr = '无截止日期';
                    if (homework.dueDate) {
                        const dueDate = new Date(homework.dueDate);
                        const dueDateOnly = new Date(dueDate);
                        dueDateOnly.setHours(0, 0, 0, 0);
                        
                        isOverdue = dueDateOnly < today;
                        dueDateStr = `截止: ${dueDate.getFullYear()}-${String(dueDate.getMonth()+1).padStart(2, '0')}-${String(dueDate.getDate()).padStart(2, '0')}`;
                    }
                    
                    // 格式化时间戳
                    const timestamp = homework.timestamp ? new Date(homework.timestamp) : new Date();
                    const timeStr = `${timestamp.getFullYear()}-${String(timestamp.getMonth()+1).padStart(2, '0')}-${String(timestamp.getDate()).padStart(2, '0')}`;
                    
                    // 将换行符替换为<br>标签
                    const contentWithLineBreaks = homework.content.replace(/\n/g, '<br>');
                    
                    html += `
                        <div class="homework-item">
                            <div class="homework-header">
                                <span class="subject-tag ${homework.subject}">${getSubjectName(homework.subject)}</span>
                                <div class="homework-meta">
                                    <span>${timeStr}</span>
                                    <span class="due-date ${isOverdue ? 'overdue' : ''}">${dueDateStr}</span>
                                </div>
                            </div>
                            <div class="homework-content">${contentWithLineBreaks}</div>
                        </div>
                    `;
                });
                
                homeworkContent.innerHTML = html;
            }
            
            // 获取科目名称
            function getSubjectName(subjectValue) {
                const subjects = {
                    'chinese': '语文',
                    'math': '数学',
                    'english': '英语',
                    'physics': '物理',
                    'chemistry': '化学',
                    'biology': '生物',
                    'history': '历史',
                    'geography': '地理',
                    'politics': '道法',
                    'other': '其他'
                };
                return subjects[subjectValue] || subjectValue;
            }
        });
    </script>
</body>
</html>
