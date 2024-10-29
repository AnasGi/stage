import subprocess
import socket
import webbrowser
import time

def get_local_ip():
    # Retrieve the local machine's IP address
    hostname = socket.gethostname()
    ip_address = socket.gethostbyname(hostname)
    return ip_address

def execute_commands():
    # Get the machine's IP address
    host_ip = get_local_ip()
    
    # Build the php artisan serve command with the IP address
    command = f'php artisan serve --host={host_ip} --port=8000'
    
    # Execute the command in a new terminal window
    execute_command_in_terminal(command, host_ip)

def execute_command_in_terminal(command, host_ip):
    try:
        # Open a new cmd window and execute the Laravel command
        subprocess.Popen(f'start cmd /k {command}', shell=True)
        print(f"Laravel server started successfully at {command}")

        # Wait a moment for the server to start
        time.sleep(5)  # Adjust as necessary for your setup

        # Construct the access URL
        url = f'http://{host_ip}:8000'
        print(f"Access your Laravel project at: {url}")

        # Open the URL in the default web browser
        webbrowser.open(url)

    except Exception as e:
        print(f"Error executing command: {e}")

if __name__ == "__main__":
    execute_commands()
