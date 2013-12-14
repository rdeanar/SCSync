SCSync
======

Download anything from SoundCloud in one click


Installation and use
------

1. Open Terminal app;
2. Type "cd ~/";
3. Type "git clone --recursive https://github.com/rdeanar/SCSync.git";
4. Wait until repository will be cloned to your home directory;
5. Open directory "apple_script" (~/SCSync/apple_script);
6. Move SCSync.app onto free space of toolbar in Finder app with pressed Cmd button on your keyboard;
7. Run app by clicking on icon in toolbar;
8. In opened Safari tab click to Authorize link and follow instructions to get auth for SCSync;
9. After you got message about successful authorization, close Safari tab and Terminal app tab;
10. Open any directory in Finder which you want to use for download music and click again on app icon into Finder toolbar;
11. By clicking will be opened several wizard dialogs. After you answer for all questions (like what you want to download and count) will be opened Terminal app and you will see progress of download;
12. When download will be finished, you will see Finder window with all downloaded tracks. Profit!


if you already made clone without "--recursive" parameter, you can run this commands to clone submodule of php implementation of soundcloud api:
git submodule init
git submodule update
