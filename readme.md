[Notes]  
1 - Create batch file "myfile.bat", like this one and save it:  
cd c:\laravel-project\  
c:\xampp\php\php.exe artisan schedule:run 1>> NUL 2>&1  
2 - Go to Windows Task Scheduler (fast way is press Win+R and enter taskschd.msc).  
3 - Click Create basic task, choose When I logon trigger and then choose Start a program -> your .bat file.  
4 - Check Open properties dialog option and click Finish.  
5 - In task properties click Triggers, then click New and add new trigger Repeat task every - 1 minute.  