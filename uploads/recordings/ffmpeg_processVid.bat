@echo off
setlocal enabledelayedexpansion

echo ============================
echo     ffmpeg version 7.0
echo ============================
echo.
:: Loop through each .webm file in the current directory
:processVids
for %%f in (*.webm) do (
    :: Check if the file name contains "_processed"
    echo %%~nf | findstr /C:"_processed" >nul
    if errorlevel 1 (
        :: Extract the file name without extension
        set "fileName=%%~nf"
        
        :: Extract the file extension
        set "fileExt=%%~xf"
        
        :: Construct the output file name by appending _processed before the extension
        set "outputFile=!fileName!_processed!fileExt!"
        
        :: Check if the processed file already exists
        if exist "!outputFile!" (
            echo Processed file already exists. Skipping...
        ) else (
            echo.
            echo.
            :: FFmpeg command to process the file faster
            ffmpeg -i "%%f" -c:v libvpx-vp9 -b:v 500k -keyint_min 120 -g 120 -c:a libopus -b:a 128k "!outputFile!"
            
            echo Processing completed. Output file is !outputFile.
            echo.
            echo.
        )
    )
)

echo.
echo ============================
echo        Process DONE
echo ============================

:: Prompt the user before closing
:checkInput
echo.
set /p userInput="Do you want to exit? (y/n): "
if /i "%userInput%"=="y" (
    echo Exiting...
    exit /b
) else if /i "%userInput%"=="n" (
    echo Continuing...
    echo.
    goto :processVids
) else (
    echo Invalid input. Please enter 'y' or 'n'.
    goto :checkInput
)

endlocal