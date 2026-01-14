FROM python:3.11-slim

WORKDIR /app

# Install dependencies
COPY requirements.txt .
RUN pip install --no-cache-dir -r requirements.txt

# Copy application
COPY app.py .
COPY templates/ templates/
COPY flag.txt /flag.txt

RUN chmod 644 /flag.txt

EXPOSE 80

CMD ["python", "app.py"]
