@echo off
echo ============================================
echo Cai dat Database - Hoa Ngoc Anh
echo ============================================
echo.

REM Kiem tra MySQL
where mysql >nul 2>nul
if %ERRORLEVEL% NEQ 0 (
    echo Loi: MySQL chua duoc cai dat hoac khong co trong PATH
    echo Vui long cai dat MySQL hoac su dung phpMyAdmin
    pause
    exit /b 1
)

echo Nhap mat khau MySQL (Enter neu khong co mat khau):
set /p MYSQL_PASS=

if "%MYSQL_PASS%"=="" (
    echo Dang tao database...
    mysql -u root < create_database.sql
    echo Dang them du lieu mau...
    mysql -u root hoa_ngoc_anh < seed_data.sql
) else (
    echo Dang tao database...
    mysql -u root -p%MYSQL_PASS% < create_database.sql
    echo Dang them du lieu mau...
    mysql -u root -p%MYSQL_PASS% hoa_ngoc_anh < seed_data.sql
)

echo.
echo ============================================
echo Hoan tat!
echo ============================================
echo.
echo Thong tin dang nhap Admin:
echo Email: admin@hoangocanh.com
echo Mat khau: 123456
echo.
pause

