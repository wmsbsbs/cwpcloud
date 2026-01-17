<?php
/**
 * 作业云端同步后端API
 * 用于处理作业的上传、下载和验证功能
 */

// 设置响应头，允许跨域请求
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

// 添加额外的头信息，避免安全服务拦截
header('X-Requested-With: XMLHttpRequest');
header('Referer: ' . $_SERVER['HTTP_HOST']);
header('User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36');

// 配置文件路径 - 使用绝对路径
define('DATA_DIR', __DIR__ . '/data');
define('SCHOOLS_FILE', DATA_DIR . '/schools.json');

// 确保数据目录存在
if (!is_dir(DATA_DIR)) {
    mkdir(DATA_DIR, 0755, true);
}

// 启用错误报告进行调试
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 确保学校数据文件存在
if (!file_exists(SCHOOLS_FILE)) {
    file_put_contents(SCHOOLS_FILE, json_encode([]));
}

// 读取学校数据
function getSchoolsData() {
    $data = file_get_contents(SCHOOLS_FILE);
    return json_decode($data, true);
}

// 保存学校数据
function saveSchoolsData($data) {
    file_put_contents(SCHOOLS_FILE, json_encode($data, JSON_PRETTY_PRINT));
}

// 处理请求
function handleRequest() {
    // 获取请求数据
    $requestData = json_decode(file_get_contents('php://input'), true);
    
    // 验证必要参数
    if (!isset($requestData['action'])) {
        return [
            'success' => false,
            'message' => '缺少action参数'
        ];
    }
    
    $action = $requestData['action'];
    
    switch ($action) {
        case 'register':
            return handleRegister($requestData);
        case 'upload':
            return handleUpload($requestData);
        case 'download':
            return handleDownload($requestData);
        case 'student':
            return handleStudentAccess($requestData);
        default:
            return [
                'success' => false,
                'message' => '未知的action参数'
            ];
    }
}

// 处理用户注册
function handleRegister($data) {
    // 验证必要参数
    if (!isset($data['schoolCode']) || !isset($data['classCode']) || !isset($data['password'])) {
        return [
            'success' => false,
            'message' => '缺少必要参数'
        ];
    }
    
    $schoolCode = $data['schoolCode'];
    $classCode = $data['classCode'];
    $password = $data['password'];
    
    // 读取学校数据
    $schoolsData = getSchoolsData();
    
    // 检查学校是否存在
    if (!isset($schoolsData[$schoolCode])) {
        // 创建新学校
        $schoolsData[$schoolCode] = [
            'classes' => []
        ];
    }
    
    // 检查班级是否存在
    if (!isset($schoolsData[$schoolCode]['classes'][$classCode])) {
        // 创建新班级
        $schoolsData[$schoolCode]['classes'][$classCode] = [
            'password' => $password,
            'homeworkData' => [],
            'lastUpdated' => time(),
            'registered' => true
        ];
        
        // 保存数据
        saveSchoolsData($schoolsData);
        
        return [
            'success' => true,
            'message' => '注册成功'
        ];
    } else {
        // 班级已存在
        return [
            'success' => false,
            'message' => '班级已存在，请使用不同的班级代码'
        ];
    }
}

// 处理作业上传
function handleUpload($data) {
    // 验证必要参数
    if (!isset($data['schoolCode']) || !isset($data['classCode']) || !isset($data['password']) || !isset($data['homeworkData'])) {
        return [
            'success' => false,
            'message' => '缺少必要参数'
        ];
    }
    
    $schoolCode = $data['schoolCode'];
    $classCode = $data['classCode'];
    $password = $data['password'];
    $homeworkData = $data['homeworkData'];
    
    // 读取学校数据
    $schoolsData = getSchoolsData();
    
    // 检查学校是否存在
    if (!isset($schoolsData[$schoolCode])) {
        // 创建新学校
        $schoolsData[$schoolCode] = [
            'classes' => []
        ];
    }
    
    // 检查班级是否存在
    if (!isset($schoolsData[$schoolCode]['classes'][$classCode])) {
        // 创建新班级
        $schoolsData[$schoolCode]['classes'][$classCode] = [
            'password' => $password,
            'homeworkData' => $homeworkData,
            'lastUpdated' => time()
        ];
    } else {
        // 验证密码
        if ($schoolsData[$schoolCode]['classes'][$classCode]['password'] !== $password) {
            return [
                'success' => false,
                'message' => '密码错误'
            ];
        }
        
        // 更新作业数据
        $schoolsData[$schoolCode]['classes'][$classCode]['homeworkData'] = $homeworkData;
        $schoolsData[$schoolCode]['classes'][$classCode]['lastUpdated'] = time();
    }
    
    // 保存数据
    saveSchoolsData($schoolsData);
    
    return [
        'success' => true,
        'message' => '作业上传成功'
    ];
}

// 处理作业下载
function handleDownload($data) {
    // 验证必要参数
    if (!isset($data['schoolCode']) || !isset($data['classCode']) || !isset($data['password'])) {
        return [
            'success' => false,
            'message' => '缺少必要参数'
        ];
    }
    
    $schoolCode = $data['schoolCode'];
    $classCode = $data['classCode'];
    $password = $data['password'];
    
    // 读取学校数据
    $schoolsData = getSchoolsData();
    
    // 检查学校是否存在
    if (!isset($schoolsData[$schoolCode])) {
        return [
            'success' => false,
            'message' => '学校不存在'
        ];
    }
    
    // 检查班级是否存在
    if (!isset($schoolsData[$schoolCode]['classes'][$classCode])) {
        return [
            'success' => false,
            'message' => '班级不存在'
        ];
    }
    
    // 验证密码
    if ($schoolsData[$schoolCode]['classes'][$classCode]['password'] !== $password) {
        return [
            'success' => false,
            'message' => '密码错误'
        ];
    }
    
    // 返回作业数据
    return [
        'success' => true,
        'homeworkData' => $schoolsData[$schoolCode]['classes'][$classCode]['homeworkData'],
        'lastUpdated' => $schoolsData[$schoolCode]['classes'][$classCode]['lastUpdated']
    ];
}

// 处理学生访问
function handleStudentAccess($data) {
    // 验证必要参数
    if (!isset($data['schoolCode']) || !isset($data['classCode'])) {
        return [
            'success' => false,
            'message' => '缺少必要参数'
        ];
    }
    
    $schoolCode = $data['schoolCode'];
    $classCode = $data['classCode'];
    
    // 读取学校数据
    $schoolsData = getSchoolsData();
    
    // 检查学校是否存在
    if (!isset($schoolsData[$schoolCode])) {
        return [
            'success' => false,
            'message' => '学校不存在'
        ];
    }
    
    // 检查班级是否存在
    if (!isset($schoolsData[$schoolCode]['classes'][$classCode])) {
        return [
            'success' => false,
            'message' => '班级不存在'
        ];
    }
    
    // 返回作业数据（不包含密码）
    return [
        'success' => true,
        'homeworkData' => $schoolsData[$schoolCode]['classes'][$classCode]['homeworkData'],
        'lastUpdated' => $schoolsData[$schoolCode]['classes'][$classCode]['lastUpdated']
    ];
}

// 处理请求并返回响应
$response = handleRequest();
echo json_encode($response);
?>
