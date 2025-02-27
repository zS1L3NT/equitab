import Foundation

// Adapted from https://gist.github.com/msanford1540/e8b6e5e85dd4a79c3f4867ec472fc1c9
protocol ApiMultipartFormDataRequest: ApiRequest {
    associatedtype Key: CodingKey
    var keyedBy: Key.Type { get }
    var boundary: String { get }
}

extension ApiMultipartFormDataRequest {
    fileprivate func field(name: String, value: String) -> Data {
        var data = Data()
        data.append("Content-Disposition: form-data; name=\"\(name)\"")
        data.append(.delimeter)
        data.append(.delimeter)
        data.append(value)
        data.append(.delimeter)
        return data
    }

    fileprivate func field(name: String, value: Data) -> Data {
        var data = Data()
        data.append(
            "Content-Disposition: form-data; name=\"\(name)\"; filename=\"\(name)\""
        )
        data.append(.delimeter)
        data.append(.delimeter)
        data.append(value)
        data.append(.delimeter)
        return data
    }

    func toData(method: HttpMethod) throws -> Data {
        var data = Data()

        for child in Mirror(reflecting: self).children {
            guard
                let label = child.label,
                let key = keyedBy.init(stringValue: label)?.stringValue
            else { continue }

            data.append("--\(boundary)--")
            data.append(.delimeter)

            switch child.value {
            case _ as String?: ()
            case let value as String:
                data.append(field(name: key, value: value))

            case _ as Data?: ()
            case let value as Data:
                data.append(field(name: key, value: value))

            case _ as Int?: ()
            case let value as Int:
                data.append(field(name: key, value: String(value)))

            default:
                throw EncodingError.invalidValue(
                    child.value as Any,
                    EncodingError.Context(
                        codingPath: [],
                        debugDescription: "Unsupported type"
                    )
                )
            }
        }

        // Soft override HTTP Method
        data.append("--\(boundary)--")
        data.append(.delimeter)
        data.append(field(name: "_method", value: "PUT"))

        data.append("--\(boundary)--")
        return data
    }
}

extension String {
    fileprivate static let delimeter = "\r\n"
}

extension Data {
    fileprivate mutating func append(_ string: String) {
        append(Data(string.utf8))
    }
}
