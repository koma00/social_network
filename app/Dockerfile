FROM python:3.10.2-alpine

WORKDIR /usr/src/app

ENV PYTHONUNBUFFERED 1

RUN apk update --no-cache \
    && apk add --no-cache postgresql-dev gcc python3-dev musl-dev

COPY ./requirements.txt .

RUN pip install --upgrade pip
RUN pip install -r requirements.txt

COPY . .